<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include ("../../modelo/especificacion_material.php");

$id_especificaciones_material = $_GET[id];
// echo $id_especificaciones_material;
$especificaciones = new especificacion_material();
$result = $especificaciones->eliminar($id_especificaciones_material);
if($result)
{
    echo "Registro Eliminado.";
}
else
{
    echo "Ocurri&oacute; un Error.";
}

?>