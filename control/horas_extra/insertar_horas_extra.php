<?php
include("../../modelo/horas_extra.php");
include("../../modelo/conf_horas_extra.php");
include("../../modelo/asignacion_cargo.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$id_conf_horas_extra = utf8_decode($_POST[id_conf_horas_extra]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);
$cantidad = utf8_decode($_POST[cantidad]);

$conf_horas_extra = new conf_horas_extra();
$horas_extra = new horas_extra();
$asignacion_cargo = new asignacion_cargo();

$conf_horas_extra->get_conf_horas_extra($id_conf_horas_extra);
$asignacion_cargo->get_asignacion_cargo($id_asignacion_cargo);


$calculo_hras = ($conf_horas_extra->factor_calculo*$cantidad)/2;

$monto = ($asignacion_cargo->salario/30/8)*$calculo_hras*2;

$result = $horas_extra->registrar_horas_extra($mes, $gestion, $conf_horas_extra->tipo_he, $conf_horas_extra->factor_calculo, $cantidad, $monto, $id_asignacion_cargo);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>