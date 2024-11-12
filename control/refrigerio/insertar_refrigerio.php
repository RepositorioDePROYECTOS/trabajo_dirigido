<?php
include("../../modelo/refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);
$monto_refrigerio = utf8_decode($_POST[monto_refrigerio]);
$total_refrigerio = utf8_decode($_POST[total_refrigerio]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$otros = 0;

$refrigerio = new refrigerio();
$result = $refrigerio->registrar_refrigerio($mes, $gestion, $dias_laborables, $dias_asistencia, $monto_refrigerio, $otros, $total_refrigerio, $id_asignacion_cargo);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>