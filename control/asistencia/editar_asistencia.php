<?php
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$id_asistencia = $_POST[id_asistencia];
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);

$asistencia = new asistencia();
$result = $asistencia->modificar_asistencia($id_asistencia, $dias_asistencia);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>