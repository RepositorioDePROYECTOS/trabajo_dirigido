<?php
include("../../modelo/conf_otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_otros_descuentos = $_POST[id_conf_otros_descuentos];
$descripcion = utf8_decode($_POST[descripcion]);
$factor_calculo = utf8_decode($_POST[factor_calculo]);
$estado = utf8_decode($_POST[estado]);

$conf_otros_descuentos = new conf_otros_descuentos();
$result = $conf_otros_descuentos->modificar_conf_otros_descuentos($id_conf_otros_descuentos, $descripcion, $factor_calculo, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>