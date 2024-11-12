<?php
include("../../modelo/eventual.php");
include("../../modelo/funciones.php");

referer_permit();

$nombres = utf8_decode($_POST[nombres]);
$apellido_paterno = utf8_decode($_POST[apellido_paterno]);
$apellido_materno = utf8_decode($_POST[apellido_materno]);
$item = utf8_decode($_POST[item]);
$nivel = utf8_decode($_POST[nivel]);
$descripcion = utf8_decode($_POST[descripcion]);
$seccion = utf8_decode($_POST[seccion]);
$salario_mensual = utf8_decode($_POST[salario_mensual]);
$estado_eventual = utf8_decode($_POST[estado_eventual]);

$eventual = new eventual();
$result = $eventual->registrar_eventual($nombres, $apellido_paterno,$apellido_materno, $item, $nivel, $descripcion, $seccion, $salario_mensual, $estado_eventual);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>