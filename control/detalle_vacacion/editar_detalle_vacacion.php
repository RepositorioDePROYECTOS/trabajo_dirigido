<?php
include("../../modelo/detalle_vacacion.php");
include("../../modelo/vacacion.php");
include("../../modelo/funciones.php");

referer_permit();

$id_detalle_vacacion = $_POST[id_detalle_vacacion];
$cantidad_dias = utf8_decode($_POST[cantidad_dias]);
$dias_utilizados = utf8_decode($_POST[dias_utilizados]);
$vacacion = new vacacion();
$detalle_vacacion = new detalle_vacacion();
$detalle_vacacion->get_detalle_vacacion($id_detalle_vacacion);
$result = $detalle_vacacion->modificar_detalle_vacacion($id_detalle_vacacion, $cantidad_dias, $dias_utilizados);
if($result)
{
	$result1 = $vacacion->modificar_vacacion_acumulada($detalle_vacacion->id_vacacion,$cantidad_dias);
		if($result1)
		{
			echo "Datos actualizados.";
		}
		else
		{
			echo "Error al modificar dias acumulados";
		}
}
else
{
	echo "No se realizaron Cambios.";
}


?>