<?php
include("../../modelo/conf_asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_asistencia = $_POST[id_conf_asistencia];
$nombre_descuento   = utf8_decode($_POST[nombre_descuento]);
$entrada_mañana     = ( $_POST[entrada_mañana] !== '' ) ? utf8_decode($_POST[entrada_mañana]) : '';
$salida_mañana      = ( $_POST[salida_mañana] !== '' ) ? utf8_decode($_POST[salida_mañana]) : '';
$entrada_tarde      = ( $_POST[entrada_tarde] !== '' ) ? utf8_decode($_POST[entrada_tarde]) : '';
$salida_tarde       = ( $_POST[salida_tarde] !== '' ) ? utf8_decode($_POST[salida_tarde]) : '';
$estado             = utf8_decode($_POST[estado]);

$conf_asistencia = new conf_asistencia();
$result = $conf_asistencia->modificar_conf_asistencia($id_conf_asistencia, $nombre_descuento, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>