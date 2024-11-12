<?php
include("../../modelo/asignacion_cargo.php");
include("../../modelo/cargo.php");
include("../../modelo/trabajador.php");
include("../../modelo/funciones.php");

referer_permit();

$id_asignacion_cargo = $_POST[id_asignacion_cargo];
$fecha_salida = utf8_decode($_POST[fecha_salida]);
$estado_asignacion = utf8_decode($_POST[estado_asignacion]);
$sindicato = utf8_decode($_POST[sindicato]);
$id_cargo = utf8_decode($_POST[id_cargo]);
$id_trabajador = utf8_decode($_POST[id_trabajador]);

$asignacion_cargo = new asignacion_cargo();
$cargo = new cargo();
$trabajador = new trabajador();
if($estado_asignacion == 'INHABILITADO')
{
	$result = $asignacion_cargo->dar_baja_asignacion_cargo($id_asignacion_cargo, $fecha_salida, $estado_asignacion);
	
	if($result)
	{
		$cargo->liberar_cargo($id_cargo);
		$trabajador->retirar_trabajador($id_trabajador);
		echo "Trabajador retirado.";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}
else
{
		echo "Error. Debe inhabilitar la asignacion del cargo";
}	


?>