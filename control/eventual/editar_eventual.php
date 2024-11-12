<?php
include("../../modelo/eventual.php");
include("../../modelo/formacion.php");
include("../../modelo/funciones.php");

referer_permit();

$id_eventual = $_POST[id_eventual];
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
$result = $eventual->modificar_eventual($id_eventual, $nombres, $apellido_paterno, $apellido_materno, $item, $nivel, $descripcion, $seccion, $salario_mensual, $estado_eventual);
if($result)

	{
		echo "Datos actualizados.";
	}
	else
	{
		echo "Ocurri&oacute; un Error.";
	}


?>