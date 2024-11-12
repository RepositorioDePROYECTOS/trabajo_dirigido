<?php
include("../../modelo/conf_asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$nombre_asistencia  = utf8_decode($_POST[nombre_asistencia]);
$inicio_mañana      = ($_POST[entrada_mañana] != null ) ? utf8_decode($_POST[entrada_mañana]) : null;
$fin_mañana         = ($_POST[salida_mañana] != null ) ? utf8_decode($_POST[salida_mañana]) : null;
$inicio_tarde       = ($_POST[entrada_tarde] != null ) ? utf8_decode($_POST[entrada_tarde]) : null;
$fin_tarde          = ($_POST[salida_tarde] != null ) ? utf8_decode($_POST[salida_tarde]) : null;
$estado             = utf8_decode($_POST[estado]);
// echo $nombre_asistencia . " - " . $inicio_mañana . " - " . $fin_mañana . " - " . $inicio_tarde . " - " . $fin_tarde . " - " . $estado;

$conf_asistencia = new conf_asistencia();
$result = $conf_asistencia->registrar_conf_asistencia($nombre_asistencia, $inicio_mañana, $fin_mañana, $inicio_tarde, $fin_tarde, $estado);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}

?>