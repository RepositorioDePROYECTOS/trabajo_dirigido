<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    referer_permit();
    $bd = new conexion();
    $val_id_proveedor  = $_POST[val_id_proveedor];
    $val_id_solicitud  = $_POST[val_id_solicitud];
    $val_tipo          = $_POST[val_tipo];
    if( $val_tipo == 'material'){
        $datos_a_eliminar = $bd->Consulta("SELECT p.id_procedimientos 
        FROM procedimientos as p
        INNER JOIN detalle_material as d ON d.id_detalle_material = p.id_detalles
        INNER JOIN solicitud_material as s ON s.id_solicitud_material = d.id_solicitud_material 
        WHERE s.id_solicitud_material=$val_id_solicitud AND p.id_proveedor=$val_id_proveedor AND p.estado=creado");
    } elseif($val_tipo == 'activo') {
        $datos_a_eliminar = $bd->Consulta("SELECT p.id_procedimientos 
        FROM procedimientos as p
        INNER JOIN detalle_activo as d ON d.id_detalle_activo = p.id_detalles
        INNER JOIN solicitud_activo  as s ON s.id_solicitud_activo  = d.id_solicitud_activo  
        WHERE s.id_solicitud_activo=$val_id_solicitud AND p.id_proveedor=$val_id_proveedor AND p.estado=creado");
    } else {
        $datos_a_eliminar = $bd->Consulta("SELECT p.id_procedimientos 
        FROM procedimientos as p
        INNER JOIN detalle_servicio as d ON d.id_detalle_servicio  = p.id_detalles
        INNER JOIN solicitud_servicio as s ON s.id_solicitud_servicio = d.id_solicitud_servicio  
        WHERE s.id_solicitud_servicio=$val_id_solicitud AND p.id_proveedor=$val_id_proveedor AND p.estado=creado");
    }
    while($datos_eliminar = $bd->getFila($datos_a_eliminar)) {
        $procedimientos_eliminar=$bd->Consulta("DELETE FROM `procedimientos` WHERE id_procedimientos=$datos_eliminar[id_procedimientos]");
    }
    if($bd->numFila_afectada() > 0){
        echo "Exito, Datos registrados.";
    } else {
        echo "Ocuri&oacute; un Error. Al subir el archivo.";
    }
?>