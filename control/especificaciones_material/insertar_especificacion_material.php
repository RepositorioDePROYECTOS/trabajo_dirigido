<?php 
    include ("../../modelo/especificacion_material.php");
    include("../../modelo/funciones.php");
    
    referer_permit();
    $id_detalle_material = intval($_POST[id_detalle_material]);
    $especificacion      = utf8_decode($_POST[detallar]);
    // echo "ID: ".$id_detalle_material." Especificacion: ".$especificacion;
    // echo "INSERT INTO especificaciones_material (especificacion, id_detalle_material) 
    // values(
    //     '$especificacion',
    //     '$id_detalle_material'
    //     )";
    
    $especificaciones = new especificacion_material();
    $result = $especificaciones->registrar_especificacion_material($especificacion, $id_detalle_material);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocurri&oacute; un Error.";
    }
?>
