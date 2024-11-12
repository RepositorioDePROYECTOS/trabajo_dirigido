<?php
include("../../modelo/conf_horas_extra.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_horas_extra = $_POST[id_conf_horas_extra];
$tipo_he = utf8_decode($_POST[tipo_he]);
$factor_calculo = utf8_decode($_POST[factor_calculo]);
$estado = utf8_decode($_POST[estado]);

$conf_horas_extra = new conf_horas_extra();
$result = $conf_horas_extra->modificar_conf_horas_extra($id_conf_horas_extra, $tipo_he, $factor_calculo, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>