<?php
include("../../modelo/horas_extra.php");
include("../../modelo/asignacion_cargo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_horas_extra = $_POST[id_horas_extra];
$gestion = utf8_decode($_POST[gestion]);
$mes = utf8_decode($_POST[mes]);
$tipo_he = utf8_decode($_POST[tipo_he]);
$factor_calculo = utf8_decode($_POST[factor_calculo]);
$cantidad = utf8_decode($_POST[cantidad]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$asignacion_cargo = new asignacion_cargo();
$asignacion_cargo->get_asignacion_cargo($id_asignacion_cargo);

$calculo_hras = ($factor_calculo*$cantidad)/2;

$monto = ($asignacion_cargo->salario/30/8)*$calculo_hras*2;

$horas_extra = new horas_extra();
$result = $horas_extra->modificar_horas_extra($id_horas_extra, $mes, $gestion,$tipo_he, $factor_calculo, $cantidad, $monto, $id_asignacion_cargo);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>