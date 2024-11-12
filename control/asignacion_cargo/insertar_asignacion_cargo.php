<?php
include("../../modelo/asignacion_cargo.php");
include("../../modelo/cargo.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_ingreso = utf8_decode($_POST[fecha_ingreso]);
$fecha_salida = utf8_decode($_POST[fecha_salida]);
$salario = utf8_decode($_POST[salario]);
$aportante_afp = utf8_decode($_POST[aportante_afp]);
$sindicato = utf8_decode($_POST[sindicato]);
$socio_fe = utf8_decode($_POST[socio_fe]);
$estado_asignacion = utf8_decode($_POST[estado_asignacion]);
$id_cargo = utf8_decode($_POST[id_cargo]);
$id_trabajador = utf8_decode($_POST[id_trabajador]);
$cargo = new cargo();
$cargo->get_cargo($id_cargo);
$asignacion_cargo = new asignacion_cargo();
$result = $asignacion_cargo->registrar_asignacion_cargo($fecha_ingreso, $fecha_salida, $cargo->item, $salario, $cargo->descripcion, $estado_asignacion, $aportante_afp, $sindicato, $socio_fe, $id_cargo, $id_trabajador);
if($result)
{
	$estado_cargo = 'OCUPADO';
	$resultado = $cargo->estado_cargo($id_cargo, $estado_cargo);
	if ($resultado)
	{
		echo "Datos registrados.";
	}
	else
	{
	echo "Ocuri&oacute; un Error.";
	}	
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>