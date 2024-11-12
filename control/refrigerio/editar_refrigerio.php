<?php
include("../../modelo/refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$id_refrigerio = $_POST[id_refrigerio];
$monto_refrigerio = $_POST[monto_refrigerio];
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);
$otros = utf8_decode($_POST[otros]);
$total_refrigerio = (($dias_asistencia*$monto_refrigerio) + $otros);

$refrigerio = new refrigerio();
$result = $refrigerio->modificar_refrigerio($id_refrigerio, $dias_laborables, $dias_asistencia, $otros, $total_refrigerio);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>