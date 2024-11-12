<?php 
    include ("../../modelo/especificacion_activo.php");
    include("../../modelo/funciones.php");
    
    referer_permit();
    $id_detalle_activo = intval($_POST[id_detalle_activo]);
    $especificacion      = utf8_decode($_POST[detallar]);
    // echo "ID: ".$id_detalle_activo." Especificacion: ".$especificacion;
    // echo "INSERT INTO especificaciones_activo (especificacion, id_detalle_activo) 
    // values(
    //     '$especificacion',
    //     '$id_detalle_activo'
    //     )";
    
    $especificaciones = new especificacion_activo();
    $result = $especificaciones->registrar_especificacion_activo($especificacion, $id_detalle_activo);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocurri&oacute; un Error.";
    }
?>
