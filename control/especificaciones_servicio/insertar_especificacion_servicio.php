<?php 
    include ("../../modelo/especificacion_servicio.php");
    include("../../modelo/funciones.php");
    
    referer_permit();
    $id_detalle_servicio = intval($_POST[id_detalle_servicio]);
    $especificacion      = utf8_decode($_POST[detallar]);
    // echo "ID: ".$id_detalle_servicio." Especificacion: ".$especificacion;
    // echo "INSERT INTO especificaciones_servicio (especificacion, id_detalle_servicio) 
    // values(
    //     '$especificacion',
    //     '$id_detalle_servicio'
    //     )";
    
    $especificaciones = new especificacion_servicio();
    $result = $especificaciones->registrar_especificacion_servicio($especificacion, $id_detalle_servicio);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocurri&oacute; un Error.";
    }
?>
