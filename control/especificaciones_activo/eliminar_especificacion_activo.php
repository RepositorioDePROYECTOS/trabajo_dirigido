<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include ("../../modelo/especificacion_activo.php");

$id_especificaciones_activo = $_GET[id];
// echo $id_especificaciones_activo;
$especificaciones = new especificacion_activo();
$result = $especificaciones->eliminar($id_especificaciones_activo);
if($result)
{
    echo "Registro Eliminado.";
}
else
{
    echo "Ocurri&oacute; un Error.";
}

?>