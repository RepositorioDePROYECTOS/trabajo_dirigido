<?php
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$asistencia = new asistencia();
$bd = new conexion();

	$verificar = $bd->Consulta("select * from asistencia where mes=$mes and gestion=$gestion and id_asignacion_cargo=$id_asignacion_cargo");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes && $verificar_1[id_asignacion_cargo] != $id_asignacion_cargo)
	{
		$asistencia->registrar_asistencia($mes,$gestion,$dias_asistencia,$dias_laborables, $id_asignacion_cargo);
	}
	else
	{
		echo "Error. Ya se tiene generada esa asistencia para ese periodo";
	}
