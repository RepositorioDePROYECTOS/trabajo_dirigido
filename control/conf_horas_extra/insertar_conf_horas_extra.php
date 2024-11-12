<?php
include("../../modelo/conf_horas_extra.php");
include("../../modelo/funciones.php");

referer_permit();

$tipo_he = utf8_decode($_POST[tipo_he]);
$factor_calculo = utf8_decode($_POST[factor_calculo]);
$estado = utf8_decode($_POST[estado]);

$conf_horas_extra = new conf_horas_extra();
$result = $conf_horas_extra->registrar_conf_horas_extra($tipo_he, $factor_calculo, $estado);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>