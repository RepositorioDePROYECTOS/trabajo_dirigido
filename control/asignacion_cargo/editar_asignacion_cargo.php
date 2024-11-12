<?php
include("../../modelo/asignacion_cargo.php");
include("../../modelo/funciones.php");

include("../../modelo/cargo.php");


referer_permit();

$cargo = new cargo();

$id_asignacion_cargo = $_POST[id_asignacion_cargo];
$fecha_ingreso = utf8_decode($_POST[fecha_ingreso]);
$fecha_salida = utf8_decode($_POST[fecha_salida]);
$item = utf8_decode($_POST[item]);

$cargo_des = utf8_decode($_POST[cargo]);
$estado_asignacion = utf8_decode($_POST[estado_asignacion]);
$aportante_afp = utf8_decode($_POST[aportante_afp]);
$sindicato = utf8_decode($_POST[sindicato]);
$socio_fe = utf8_decode($_POST[socio_fe]);
$id_cargo = utf8_decode($_POST[id_cargo]);

$cargo->get_cargo($id_cargo);
$id_trabajador = utf8_decode($_POST[id_trabajador]);

$asignacion_cargo = new asignacion_cargo();
$result = $asignacion_cargo->modificar_asignacion_cargo($id_asignacion_cargo, $fecha_ingreso, $fecha_salida, $item, $cargo->salario_mensual, $cargo_des, $estado_asignacion, $aportante_afp, $sindicato, $socio_fe, $id_cargo, $id_trabajador);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>