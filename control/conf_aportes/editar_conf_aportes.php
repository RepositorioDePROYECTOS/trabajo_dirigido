<?php
include("../../modelo/conf_aportes.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_aporte = $_POST[id_conf_aporte];
$tipo_aporte = utf8_decode($_POST[tipo_aporte]);
$rango_inicial = utf8_decode($_POST[rango_inicial]);
$rango_final = utf8_decode($_POST[rango_final]);
$porc_aporte = utf8_decode($_POST[porc_aporte]);
$estado = utf8_decode($_POST[estado]);

$conf_aportes = new conf_aportes();
$result = $conf_aportes->modificar_conf_aportes($id_conf_aporte, $tipo_aporte, $rango_inicial, $rango_final, $porc_aporte, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>