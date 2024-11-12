<?php
include("../../modelo/asistencia_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$id_asistencia_refrigerio = $_POST[id_asistencia_refrigerio];
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);

$asistencia_refrigerio = new asistencia_refrigerio();
$result = $asistencia_refrigerio->modificar_asistencia_refrigerio($id_asistencia_refrigerio, $dias_laborables, $dias_asistencia);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>