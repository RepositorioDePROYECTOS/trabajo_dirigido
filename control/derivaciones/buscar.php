<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
$id   = $_GET[id];
$tipo = $_GET[tipo];
$bd = new conexion();
// echo json_encode(array(
//     "success" => true,
//     "id"      => $id,
//     "tipo"    => $tipo,));

$fecha = "";
$nombre_solicitante = "";
$existencia = "";
$tipo_buscador = "";
$oficina_solicitante = "";
$unidad_solicitante = "";
$objetivo = "";
$justificativo = "";
$nro_solicitud = "";
$id_d_trabajador = 0;
$array = array();
$arrays = array();
$old = array();
$oldest = array();

if ($tipo == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id");
    $registro_sol = $bd->getFila($registros_solicitud);

    $detalles = $bd->Consulta("SELECT * FROM detalle_material WHERE id_solicitud_material=$id");
    while($datos = $bd->getFila($detalles)){
        $arrays = array(
            'id'                   => utf8_encode($datos[id_detalle_material]),
            'descripcion'          => utf8_encode($datos[descripcion]),
            'unidad_medida'        => utf8_encode($datos[unidad_medida]),
            'cantidad_solicitada'  => utf8_encode($datos[cantidad_solicitada]),
            'precio_unitario'      => utf8_encode($datos[precio_unitario]),
            'precio_total'         => utf8_encode($datos[precio_total])
        );
        array_push($array, $arrays);
    }
    $historico = $bd->Consulta("SELECT d.id_trabajador, h.tipo_solicitud, h.created_at, h.estado, t.nombres, t.apellido_paterno, t.apellido_materno 
        FROM historicos as h 
        INNER JOIN derivaciones as d ON h.id_derivaciones = d.id_derivacion 
        INNER JOIN trabajador as t ON t.id_trabajador = h.id_trabajador 
        WHERE h.id_solicitud=$id");
    while($historicos = $bd->getFila($historico)){
        $id_d_trabajador = $historicos[id_trabajador];
        $diferencia_dias = 0;
        $diferencia_horas = 0;
        $tiempo_demora = 0;
        $demora_dias = "";
        $diferencia_texto = "";
        if($historicos[estado] == "solicitar"){
            
        } elseif($historicos[estado] == "devuelto"){
            $tiempo_demora=1.5;
        } elseif($historicos[estado] == "verificado"){
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "presupuestado") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "aprobado por RPA") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "proveedor asignado") {
            $tiempo_demora=2;
        } elseif ($historicos[estado] == "memorandun creado"){
            $tiempo_demora =0;
        }
        $fecha_actual = new DateTime($historicos[created_at]);
        $fecha_creacion = $historicos[created_at];
        $usuario_designado=$bd->Consulta("SELECT nombre_apellidos FROM usuario WHERE id_usuario=$historicos[id_trabajador]");
        $user_designado=$bd->getFila($usuario_designado);

        if (!empty($oldest)) {
            $fecha_anterior = new DateTime($oldest['fecha']);
            $fecha_respuesta = $oldest['fecha'];
            $pruebas = diferenciafechas($fecha_respuesta, $fecha_creacion);
            $diferencia  = $fecha_actual->diff($fecha_anterior);
            // $diferencia_dias = round($diferencia_segundos / 86400, 1);
            $diferencia_dias = $diferencia->days;
            $diferencia_horas = $diferencia->h;
        } else {
            $diferencia_dias = 0;
            $diferencia_horas = 0;
        }
        // Convertir a formato "x días y medio"
        $dias = floor($diferencia_dias); // Parte entera de los días
        $fraccion = $diferencia_dias - $dias; // Parte decimal (fracción de día)
        $horas_fraccion = $fraccion * 24; // Convertir fracción a horas
        $horas = floor($horas_fraccion); // Parte entera de las horas

        // Generar el texto con la diferencia de tiempo
        if ($diferencia_dias > 0) {
            $diferencia_texto = $diferencia_dias . " día" . ($diferencia_dias > 1 ? "s" : "");
            if ($diferencia_horas > 0) {
                $diferencia_texto .= " y " . $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
            }
        } elseif ($diferencia_horas > 0) {
            $diferencia_texto = $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
        } else {
            $diferencia_texto = "0 días";
        }

        if(intval($pruebas[2]) > 3){
            if(intval($pruebas[2]) > 3){
                // if($diferencia_dias > intval($pruebas[2])){
                    $demora_dias = "si";
                // }
            } else {
                $diferencia_dias = 0;
            }
        }

        $oldest = array(
            "tipo_solicitud"    => utf8_encode(strtoupper($historicos[tipo_solicitud])),
            "fecha"             => date('d-m-Y H:i:s',strtotime($historicos[created_at])),
            "responsable"       => utf8_encode(strtoupper($historicos[nombres]." ".$historicos[apellido_paterno]." ".$historicos[apellido_materno])),
            "estado"            => utf8_encode(strtoupper($historicos[estado])),
            "diff"              => $diferencia_dias,
            "retraso"           => $demora_dias,
            "tiempo_demora"     => $tiempo_demora,
            "literal"           => $diferencia_texto,
            "pruebas_diff"      => intval($pruebas[2]),
            "consulta"          => "SELECT d.id_trabajador, h.tipo_solicitud, h.created_at, h.estado, t.nombres, t.apellido_paterno, t.apellido_materno 
            FROM historicos as h 
            INNER JOIN derivaciones as d ON h.id_derivaciones = d.id_derivacion 
            INNER JOIN trabajador as t ON t.id_trabajador = h.id_trabajador 
            WHERE h.id_solicitud=$id"
        );
        array_push($old, $oldest);
    }
    $tipo_buscador = "ALMACENERO";

    $fecha               = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante  = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia          = utf8_encode($registro_sol[existencia_material]);
    $oficina_solicitante = utf8_encode($registro_sol[oficina_solicitante]);
    $unidad_solicitante  = utf8_encode($registro_sol[unidad_solicitante]);
    $designado           = utf8_encode(strtoupper($user_designado[nombre_apellidos]));
    $objetivo            = utf8_encode(strtoupper($registro_sol[objetivo_contratacion]));
    $justificativo       = utf8_encode(strtoupper($registro_sol[justificativo]));
    $nro_solicitud       = utf8_encode($registro_sol[nro_solicitud_material]);
    echo json_encode(array(
        "success"             => true,
        "fecha"               => $fecha,
        "designado"           => $designado,
        // "id_d_trabajador"     => $id_d_trabajador,
        "existencia"          => $existencia,
        "nombre"              => $nombre_solicitante,
        "oficina_solicitante" => $oficina_solicitante,
        "unidad_solicitante"  => $unidad_solicitante,
        "objetivo"            => $objetivo,
        "justificativo"       => $justificativo,
        "nro"                 => "Solicitud ".$nro_solicitud,
        "tipo_buscador"       => $tipo_buscador,
        "detalles"            => $array,
        "info"                => $old,
    ));
} elseif ($tipo == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id");
    $registro_sol = $bd->getFila($registros_solicitud);
    $detalles = $bd->Consulta("SELECT * FROM detalle_activo WHERE id_solicitud_activo=$id");
    while($datos = $bd->getFila($detalles)){
        $arrays = array(
            'id'                   => utf8_encode($datos[id_detalle_activo]),
            'descripcion'          => utf8_encode($datos[descripcion]),
            'unidad_medida'        => utf8_encode($datos[unidad_medida]),
            'cantidad_solicitada'  => utf8_encode($datos[cantidad_solicitada]),
            'precio_unitario'      => utf8_encode($datos[precio_unitario]),
            'precio_total'         => utf8_encode($datos[precio_total])
        );
        array_push($array, $arrays);
    }
    $historico = $bd->Consulta("SELECT d.id_trabajador, h.tipo_solicitud, h.created_at, h.estado, t.nombres, t.apellido_paterno, t.apellido_materno 
        FROM historicos as h 
        INNER JOIN derivaciones as d ON h.id_derivaciones = d.id_derivacion 
        INNER JOIN trabajador as t ON t.id_trabajador = h.id_trabajador 
        WHERE h.id_solicitud=$id");
    while($historicos = $bd->getFila($historico)){
        $id_d_trabajador = $historicos[id_trabajador];
        $diferencia_dias = 0;
        $diferencia_horas = 0;
        $tiempo_demora = 0;
        $demora_dias = "";
        $diferencia_texto = "";
        if($historicos[estado] == "solicitar"){
            
        } elseif($historicos[estado] == "devuelto"){
            $tiempo_demora=1.5;
        } elseif($historicos[estado] == "verificado"){
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "presupuestado") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "aprobado por RPA") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "proveedor asignado") {
            $tiempo_demora=2;
        } elseif($historicos[estado] == "memorandun creado") {
            $tiempo_demora = 0;
        }

        $fecha_actual = new DateTime($historicos[created_at]);
        $fecha_creacion = $historicos[created_at];
        $usuario_designado=$bd->Consulta("SELECT nombre_apellidos FROM usuario WHERE id_usuario=$historicos[id_trabajador]");
        $user_designado=$bd->getFila($usuario_designado);

        if (!empty($oldest)) {
            $fecha_anterior = new DateTime($oldest['fecha']);
            $fecha_respuesta = $oldest['fecha'];
            $pruebas = diferenciafechas($fecha_respuesta, $fecha_creacion);
            $diferencia  = $fecha_actual->diff($fecha_anterior);
            // $diferencia_dias = round($diferencia_segundos / 86400, 1);
            $diferencia_dias = $diferencia->days;
            $diferencia_horas = $diferencia->h;
        } else {
            $diferencia_dias = 0;
            $diferencia_horas = 0;
        }
        // Convertir a formato "x días y medio"
        $dias = floor($diferencia_dias); // Parte entera de los días
        $fraccion = $diferencia_dias - $dias; // Parte decimal (fracción de día)
        $horas_fraccion = $fraccion * 24; // Convertir fracción a horas
        $horas = floor($horas_fraccion); // Parte entera de las horas

        // Generar el texto con la diferencia de tiempo
        if ($diferencia_dias > 0) {
            $diferencia_texto = $diferencia_dias . " día" . ($diferencia_dias > 1 ? "s" : "");
            if ($diferencia_horas > 0) {
                $diferencia_texto .= " y " . $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
            }
        } elseif ($diferencia_horas > 0) {
            $diferencia_texto = $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
        } else {
            $diferencia_texto = "0 días";
        }

        if(intval($pruebas[2]) > 3){
            if(intval($pruebas[2]) > 3){
                // if($diferencia_dias > intval($pruebas[2])){
                    $demora_dias = "si";
                // }
            } else {
                $diferencia_dias = 0;
            }
        }

        $oldest = array(
            "tipo_solicitud"    => utf8_encode(strtoupper($historicos[tipo_solicitud])),
            "fecha"             => date('d-m-Y H:i:s',strtotime($historicos[created_at])),
            "responsable"       => utf8_encode(strtoupper($historicos[nombres]." ".$historicos[apellido_paterno]." ".$historicos[apellido_materno])),
            "estado"            => utf8_encode(strtoupper($historicos[estado])),
            "diff"              => $diferencia_dias,
            "retraso"           => $demora_dias,
            "tiempo_demora"     => $tiempo_demora,
            "literal"           => $diferencia_texto,
            "pruebas_diff"      => intval($pruebas[2])
        );
        array_push($old, $oldest);
    }

    $tipo_buscador = "ACTIVOS";
    $unidad_solicitante   = utf8_encode($registro_sol[unidad_solicitante]);

    $fecha                = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante   = utf8_encode($registro_sol[nombre_solicitante]);
    $oficina_solicitante  = utf8_encode($registro_sol[oficina_solicitante]);
    $designado            = utf8_encode(strtoupper($user_designado[nombre_apellidos]));
    $objetivo             = utf8_encode(strtoupper($registro_sol[objetivo_contratacion]));
    $justificativo        = utf8_encode(strtoupper($registro_sol[justificativo]));
    $nro_solicitud        = utf8_encode($registro_sol[nro_solicitud_activo]);
    echo json_encode(array(
        "success"             => true,
        "fecha"               => $fecha,
        "designado"           => $designado,
        // "id_d_trabajador"     => $id_d_trabajador,
        "existencia"          => $existencia,
        "nombre"              => $nombre_solicitante,
        "oficina_solicitante" => $oficina_solicitante,
        "unidad_solicitante"  => $unidad_solicitante,
        "objetivo"            => $objetivo,
        "justificativo"       => $justificativo,
        "nro"                 => "Solicitud ".$nro_solicitud,
        "tipo_buscador"       => $tipo_buscador,
        "detalles"            => $array,
        "info"                => $old,
    ));
} elseif ($tipo == 'servicio') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id");
    $registro_sol = $bd->getFila($registros_solicitud);
    $detalles = $bd->Consulta("SELECT * FROM detalle_servicio WHERE id_solicitud_servicio=$id");
    while($datos = $bd->getFila($detalles)){
        $arrays = array(
            'id'                   => utf8_encode($datos[id_detalle_servicio]),
            'descripcion'          => utf8_encode($datos[descripcion]),
            'unidad_medida'        => utf8_encode($datos[unidad_medida]),
            'cantidad_solicitada'  => utf8_encode($datos[cantidad_solicitada]),
            'precio_unitario'      => utf8_encode($datos[precio_unitario]),
            'precio_total'         => utf8_encode($datos[precio_total]),
        );
        array_push($array, $arrays);
    }
    $historico = $bd->Consulta("SELECT d.id_trabajador, h.tipo_solicitud, h.created_at, h.estado, t.nombres, t.apellido_paterno, t.apellido_materno FROM historicos as h INNER JOIN derivaciones as d ON h.id_derivaciones = d.id_derivacion INNER JOIN trabajador as t ON t.id_trabajador = h.id_trabajador WHERE h.id_solicitud=$id");
    while($historicos = $bd->getFila($historico)){
        $id_d_trabajador = $historicos[id_trabajador];
        $diferencia_dias = 0;
        $diferencia_horas = 0;
        $tiempo_demora = 0;
        $demora_dias = "";
        $diferencia_texto = "";
        if($historicos[estado] == "solicitar"){
            
        } elseif($historicos[estado] == "devuelto"){
            $tiempo_demora=1.5;
        } elseif($historicos[estado] == "verificado"){
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "presupuestado") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "aprobado por RPA") {
            $tiempo_demora=1.5;
        } elseif ($historicos[estado] == "proveedor asignado") {
            $tiempo_demora=2;
        } elseif($historicos[estado] == "memorandun creado"){
            $tiempo_demora = 0;
        }
        $fecha_actual = new DateTime($historicos[created_at]);
        $fecha_creacion = $historicos[created_at];
        $usuario_designado=$bd->Consulta("SELECT nombre_apellidos FROM usuario WHERE id_usuario=$historicos[id_trabajador]");
        $user_designado=$bd->getFila($usuario_designado);

        if (!empty($oldest)) {
            $fecha_anterior = new DateTime($oldest['fecha']);
            $fecha_respuesta = $oldest['fecha'];
            $pruebas = diferenciafechas($fecha_respuesta, $fecha_creacion);
            $diferencia  = $fecha_actual->diff($fecha_anterior);
            // $diferencia_dias = round($diferencia_segundos / 86400, 1);
            $diferencia_dias = $diferencia->days;
            $diferencia_horas = $diferencia->h;
        } else {
            $diferencia_dias = 0;
            $diferencia_horas = 0;
        }
        // Convertir a formato "x días y medio"
        $dias = floor($diferencia_dias); // Parte entera de los días
        $fraccion = $diferencia_dias - $dias; // Parte decimal (fracción de día)
        $horas_fraccion = $fraccion * 24; // Convertir fracción a horas
        $horas = floor($horas_fraccion); // Parte entera de las horas

        // Generar el texto con la diferencia de tiempo
        if ($diferencia_dias > 0) {
            $diferencia_texto = $diferencia_dias . " día" . ($diferencia_dias > 1 ? "s" : "");
            if ($diferencia_horas > 0) {
                $diferencia_texto .= " y " . $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
            }
        } elseif ($diferencia_horas > 0) {
            $diferencia_texto = $diferencia_horas . " hora" . ($diferencia_horas > 1 ? "s" : "");
        } else {
            $diferencia_texto = "0 días";
        }

        if(intval($pruebas[2]) > 3){
            if(intval($pruebas[2]) > 3){
                // if($diferencia_dias > intval($pruebas[2])){
                    $demora_dias = "si";
                // }
            } else {
                $diferencia_dias = 0;
            }
        }

        $oldest = array(
            "tipo_solicitud"    => utf8_encode(strtoupper($historicos[tipo_solicitud])),
            "fecha"             => date('d-m-Y H:i:s',strtotime($historicos[created_at])),
            "responsable"       => utf8_encode(strtoupper($historicos[nombres]." ".$historicos[apellido_paterno]." ".$historicos[apellido_materno])),
            "estado"            => utf8_encode(strtoupper($historicos[estado])),
            "diff"              => $diferencia_dias,
            "retraso"           => $demora_dias,
            "tiempo_demora"     => $tiempo_demora,
            "literal"           => $diferencia_texto,
            "pruebas_diff"      => intval($pruebas[2])
        );
        array_push($old, $oldest);
    }
    $tipo_buscador = "SERVICIO";
    $unidad_solicitante   = utf8_encode($registro_sol[unidad_solicitante]);
    $fecha                = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante   = utf8_encode($registro_sol[nombre_solicitante]);
    $oficina_solicitante  = utf8_encode($registro_sol[oficina_solicitante]);
    $designado            = utf8_encode(strtoupper($user_designado[nombre_apellidos]));
    $objetivo             = utf8_encode(strtoupper($registro_sol[objetivo_contratacion]));
    $justificativo        = utf8_encode(strtoupper($registro_sol[justificativo]));
    $nro_solicitud        = utf8_encode($registro_sol[nro_solicitud_servicio]);
    echo json_encode(array(
        "success"             => true,
        "fecha"               => $fecha,
        "designado"           => $designado,
        // "id_d_trabajador"     => $id_d_trabajador,
        "existencia"          => $existencia,
        "nombre"              => $nombre_solicitante,
        "oficina_solicitante" => $oficina_solicitante,
        "unidad_solicitante"  => $unidad_solicitante,
        "tipo_buscador"       => $tipo_buscador,
        "objetivo"            => $objetivo,
        "justificativo"       => $justificativo,
        "nro"                 => "Solicitud ".$nro_solicitud,
        "detalles"            => $array,
        "info"                => $old,
    ));
} else {
    echo json_encode(array(
        "success" => false, "message" => utf8_encode('Error No se encontro la solicitud')
    ));
}
