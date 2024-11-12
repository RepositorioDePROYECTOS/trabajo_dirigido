<?php
include("../../modelo/conf_impositiva.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_impositiva = $_POST[id_conf_impositiva];
$salario_minimo = utf8_decode($_POST[salario_minimo]);
$cant_sm = utf8_decode($_POST[cant_sm]);
$porcentaje_imp = utf8_decode($_POST[porcentaje_imp]);
$estado = utf8_decode($_POST[estado]);

$conf_impositiva = new conf_impositiva();
$result = $conf_impositiva->modificar_conf_impositiva($id_conf_impositiva, $salario_minimo, $cant_sm, $porcentaje_imp, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>