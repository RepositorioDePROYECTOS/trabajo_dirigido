<?php
include("../../modelo/entidad.php");
include("../../modelo/funciones.php");

referer_permit();

$id_entidad = $_POST[id_entidad];
$nombre_entidad = utf8_decode($_POST[nombre_entidad]);
$ubicacion = utf8_decode($_POST[ubicacion]);
$direccion = utf8_decode($_POST[direccion]);
$telefonos = utf8_decode($_POST[telefonos]);
$correo = utf8_decode($_POST[correo]);

$entidad = new entidad();
$result = $entidad->modificar_entidad($id_entidad, $nombre_entidad, $ubicacion, $direccion, $telefonos, $correo);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>