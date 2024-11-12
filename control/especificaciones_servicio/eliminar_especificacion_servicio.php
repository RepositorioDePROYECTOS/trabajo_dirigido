<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include ("../../modelo/especificacion_servicio.php");

$id_especificaciones_servicio = $_GET[id];
// echo $id_especificaciones_servicio;
$especificaciones = new especificacion_servicio();
$result = $especificaciones->eliminar($id_especificaciones_servicio);
if($result)
{
    echo "Registro Eliminado.";
}
else
{
    echo "Ocurri&oacute; un Error.";
}

?>