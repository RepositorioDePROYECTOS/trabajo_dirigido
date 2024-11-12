<?php
include("../../modelo/nombre_planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_nombre_planilla = $_POST[id_nombre_planilla];
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$nombre_planilla = utf8_decode($_POST[nombre_planilla]);
$fecha_creacion = utf8_decode($_POST[fecha_creacion]);
$estado = utf8_decode($_POST[estado]);

$nombre_planilla = new nombre_planilla();
$result = $nombre_planilla->modificar_nombre_planilla($id_nombre_planilla, $mes, $gestion, $nombre_planilla, $fecha_creacion, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>