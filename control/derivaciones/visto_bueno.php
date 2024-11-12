<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    include("../../modelo/requisitos.php");

    referer_permit();
    setlocale(LC_TIME, "es_ES");
    ini_set('date.timezone', 'America/La_Paz');


    $id_solicitud     = $_GET[id_solicitud];
    $id_detalle       = $_GET[id_detalle];
    $tipo             = $_GET[tipo];
    $estado           = $_GET[estado];
    $id_usuario       = $_GET[id_usuario];
    $nivel            = $_GET[nivel];
    $id_proveedor     = $_GET[id_proveedor];
    $fecha            = date('Y-m-d H:i:s');

    $requisitos = new requisitos();
    $bd = new conexion();

    // echo json_encode(array("success"=>true,"message"=>"sol: ".$id_solicitud."detalle: ".$id_detalle."tipo: ".$tipo."estado: ".$estado."usuario: ".$id_usuario."nivel: ".$nivel."Proveedor: ".$id_proveedor));
    // print_r($array);

    $trabajador = $bd->Consulta("SELECT t.id_trabajador, u.nivel 
            FROM trabajador as t 
            INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
    $t = $bd->getFila($trabajador);
    $id_t = $t[id_trabajador];
    $derivaciones = $bd->Consulta("SELECT * 
            FROM derivaciones 
            WHERE id_solicitud=$id_solicitud");
    $derivacion   = $bd->getFila($derivaciones);
    if ($nivel == "RPA") {
        
        // buscamos las derivaciones para tener la llave y comparar en requisitos
        // solo nos devolvera un valor, ese ID es unico para las demas tablas
        $buscar_derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'");
        $buscar_derivacion = $bd->getFila($buscar_derivaciones);
        // buscamos los requisitos con estados ya en el visto bueno del rpa
        $contar_requisitos = $bd->Consulta("SELECT COUNT(id_requisitos) as total FROM requisitos WHERE estado='visto bueno rpa' AND id_solicitud=$id_solicitud AND id_derivaciones=$buscar_derivacion[id_derivacion]");
        $c_requisitos = $bd->getFila($contar_requisitos);
        // echo "Requisitos = ".$c_requisitos[total]; // Pruebas

        // buscamos en las solicitudes cuantos detalles tiene cada solicitud
        if ($tipo == "material") {
            $contar_detalles = $bd->Consulta("SELECT COUNT(id_detalle_material) as detalles FROM detalle_material WHERE id_solicitud_material = $id_solicitud");
            $c_detalles = $bd->getFila($contar_detalles);
        }
        if ($tipo == "activo") {
            $contar_detalles = $bd->Consulta("SELECT COUNT(id_detalle_activo) as detalles FROM detalle_activo WHERE id_solicitud_activo = $id_solicitud");
            $c_detalles = $bd->getFila($contar_detalles);
        }
        if ($tipo == "servicio") {
            $contar_detalles = $bd->Consulta("SELECT COUNT(id_detalle_servicio) as detalles FROM detalle_servicio WHERE id_solicitud_servicio = $id_solicitud");
            $c_detalles = $bd->getFila($contar_detalles);
        }
        // echo "Detalles = ".$c_detalles[detalles]; // Pruebas

        // comparamos los detalles de cada solicitud con todos los requisitos ya validados por el rpa y adquisiciones
        // echo json_encode(array("success" => true, "message" => $estado." Valores: ".$c_detalles[detalles]));
        // echo json_encode(array("success" => true, "message" => $estado." Valores: ".$c_requisitos[total]));
        if (($c_detalles[detalles]) == ($c_requisitos[total])) {
            // if ($estado != "no_visto_bueno") {
            //     echo json_encode(array("success" => false, "message" => "Los datos ya fueron procesados!"));
            // }
        } else {
            if ($estado != "no_visto_bueno") {
                $estado_nuevo = "visto bueno " . strtoupper($t[nivel]);

                if ($tipo == "material") {
                    $estado_nuevo_solicitud = $bd->Consulta("UPDATE solicitud_material set estado_solicitud_material='VISTO BUENO RPA' where id_solicitud_material=$id_solicitud");
                }
                if ($tipo == "activo") {
                    $estado_solicitud = $bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='VISTO BUENO RPA' where id_solicitud_activo=$id_solicitud");
                }
                if ($tipo == "servicio") {
                    $estado_solicitud = $bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='VISTO BUENO RPA' where id_solicitud_servicio=$id_solicitud");
                }

                $derivacion_estado = $bd->Consulta("UPDATE derivaciones set estado_derivacion='visto bueno rpa' where id_derivacion=$derivacion[id_derivacion]");
                $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($derivacion[id_derivacion], $id_solicitud, $id_t, '$tipo', '$estado')");
                // echo json_encode(array("success"=>true,"message"=>"No visto bueno".$estado." Valores: ".$c_detalles[detalles])." - ".($c_requisitos[total]));
            } else {
                $estado_nuevo = "sin visto bueno " . strtoupper($t[nivel]);
                if ($tipo == "material") {
                    $estado_solicitud = $bd->Consulta("UPDATE solicitud_material set estado_solicitud_material='SIN VISTO BUENO RPA' where id_solicitud_material=$id_solicitud");
                }
                if ($tipo == "activo") {
                    $estado_solicitud = $bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='SIN VISTO BUENO RPA' where id_solicitud_activo=$id_solicitud");
                }
                if ($tipo == "servicio") {
                    $estado_solicitud = $bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='SIN VISTO BUENO RPA' where id_solicitud_servicio=$id_solicitud");
                }
                $derivacion_estado = $bd->Consulta("UPDATE derivaciones set estado_derivacion='sin visto bueno rpa' where id_derivacion=$derivacion[id_derivacion]");
                $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($derivacion[id_derivacion], $id_solicitud, $id_t, '$tipo', '$estado_nuevo')");
                // echo json_encode(array("success"=>true,"message"=>"Si visto bueno".$estado." Valores: ".$c_detalles[detalles])." - ".($c_requisitos[total]));
            }
            $buscar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor");
            while ($buscar = $bd->getFila($buscar_requisitos)) {
                if ($estado != "no_visto_bueno") {
                    $cambios = $bd->Consulta("UPDATE requisitos SET estado='visto bueno rpa' WHERE id_requisitos=$buscar[id_requisitos]");
                } else {
                    $cambios = $bd->Consulta("UPDATE requisitos SET estado='sin visto bueno rpa' WHERE id_requisitos=$buscar[id_requisitos]");
                }
            }
        }
    }
    $show_message = "";
    if ($estado != "no_visto_bueno") {
        $show_message = "Solicitud Aprobada";
    } else {
        $show_message = "Ocuri&oacute; un Error, Solicitud Rechazada!";
    }
    if ($bd->numFila_afectada() > 0) {
        echo json_encode(array("success" => true, "message" => $show_message));
    } else {
        echo json_encode(array("success" => false, "message" => $show_message));
    }
?>