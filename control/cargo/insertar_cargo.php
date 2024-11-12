<?php
include("../../modelo/cargo.php");
include("../../modelo/funciones.php");

referer_permit();

$item = utf8_decode($_POST[item]);
$nivel = utf8_decode($_POST[nivel]);
$seccion = utf8_decode($_POST[seccion]);
$descripcion = utf8_decode($_POST[descripcion]);
$salario_mensual = utf8_decode($_POST[salario_mensual]);
$estado_cargo = utf8_decode($_POST[estado_cargo]);

$cargo = new cargo();
$result = $cargo->registrar_cargo($item, $nivel, $seccion, $descripcion, $salario_mensual, $estado_cargo);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>