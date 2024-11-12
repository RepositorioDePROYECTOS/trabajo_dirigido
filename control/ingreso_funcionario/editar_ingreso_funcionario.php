<?php
include("../../modelo/ingreso_funcionario.php");
include("../../modelo/funciones.php");

referer_permit();

$id_refrigerio = $_POST[id_refrigerio];
$monto_refrigerio = $_POST[monto_refrigerio];
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);
$total_refrigerio = $dias_asistencia*$monto_refrigerio;

$ingreso_funcionario = new ingreso_funcionario();
$result = $ingreso_funcionario->modificar_ingreso_funcionario($id_refrigerio, $dias_laborables, $dias_asistencia, $total_refrigerio);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>