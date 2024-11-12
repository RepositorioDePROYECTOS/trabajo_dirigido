<?php
include("../../modelo/conf_vacacion.php");
include("../../modelo/funciones.php");

referer_permit();

$anio_inicio = utf8_decode($_POST[anio_inicio]);
$anio_fin = utf8_decode($_POST[anio_fin]);
$dias_vacacion = utf8_decode($_POST[dias_vacacion]);
$estado_vaca = utf8_decode($_POST[estado_vaca]);

$conf_vacacion = new conf_vacacion();
$result = $conf_vacacion->registrar_conf_vacacion($anio_inicio, $anio_fin, $dias_vacacion, $estado_vaca);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>