<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    referer_permit();
    setlocale(LC_TIME, "es_ES");
    ini_set('date.timezone', 'America/La_Paz');
    
    $val_id_proveedor  = $_POST[val_id_proveedor];
    $val_id_solicitud  = $_POST[val_id_solicitud];
    $val_id_derivacion = $_POST[val_id_derivacion];
    $val_tipo          = $_POST[val_tipo];
    $id_usuario        = $_POST[id_usuario];
    $rpa               = $_POST[rpa];
    $responsables      = $_POST[responsables];
    $cuce              = ($_POST[cuce] != '') ? $_POST[cuce] : '';
    $fecha_respuesta   = date('Y-m-d H:i:s');
    $fecha             = date('Y-m-d');

    $bd = new conexion();
    $array = array();
    foreach ( $responsables as $responsable ) {
        
        if ($val_tipo == "material") {
            $requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_material as id_detalle, r.id_requisitos 
                    FROM detalle_material as d
                    INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                    WHERE id_solicitud_material=$val_id_solicitud
                    AND  r.id_proveedor=$val_id_proveedor");
        } elseif ($val_tipo == 'activo') {
            $requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_activo as id_detalle, r.id_requisitos 
                    FROM detalle_activo as d
                    INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo 
                    where id_solicitud_activo= $val_id_solicitud
                    AND  r.id_proveedor=$val_id_proveedor");
        } else {
            $requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_servicio as id_detalle, r.id_requisitos 
                FROM detalle_servicio as d
                INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
                where id_solicitud_servicio = $val_id_solicitud
                AND  r.id_proveedor=$val_id_proveedor");
        }
        while($requisitos = $bd->getFila($requisitos_detallados) ){
            array_push($array,
                array(
                    "responsable" => $responsable, 
                    "id_detalle"  => $requisitos['id_detalle'],
                    "id_requistos"=> $requisitos['id_requisitos'],
                    "tipo"        => $val_tipo, 
                )
            );
        }
    }
    $update_derivacion = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='memorandun' WHERE id_derivacion=$val_id_derivacion");
    foreach ($array as $key) {
        $key[responsable];
        $insertar = $bd->Consulta("INSERT INTO procedimientos (id_derivacion, id_requisitos, id_detalles, id_proveedor, fecha_elaboracion, responsable, designado, cuce, created_at, tipo, estado) VALUES ($val_id_derivacion, $key[id_requistos], $key[id_detalle], $val_id_proveedor, '$fecha', $rpa, $key[responsable], '$cuce', '$fecha_respuesta', '$val_tipo', 'creado')");
    }
    $trabajador = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador   WHERE u.id_usuario=$id_usuario");
    $t = $bd->getFila($trabajador);
    $id_t = $t[id_trabajador];


    if($val_tipo == "material"){
        $estado_solicitud = $bd->Consulta("UPDATE solicitud_material set estado_solicitud_material='MEMORANDUN' where id_solicitud_material=$val_id_solicitud");
    }
    if($val_tipo == "activo")  {
        $estado_solicitud = $bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='MEMORANDUN' where id_solicitud_activo=$val_id_solicitud");
    }
    if($val_tipo == "servicio"){
        $estado_solicitud = $bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='MEMORANDUN' where id_solicitud_servicio=$val_id_solicitud");
    }

    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($val_id_derivacion, $val_id_solicitud, $id_t, '$val_tipo', 'memorandun creado')");   
// echo json_encode($array);


    if($bd->numFila_afectada() > 0){
        echo json_encode(array("success"=> true, "message"=>"Exito, Datos registrados."));
    } else {
        echo json_encode(array("success"=> false, "message"=>"Ocuri&oacute; un Error. Al subir el archivo."));
    }
?>