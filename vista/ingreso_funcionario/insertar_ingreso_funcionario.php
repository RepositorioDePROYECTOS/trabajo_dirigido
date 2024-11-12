<?php
include("../../modelo/ingreso_funcionario.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_registro = utf8_decode($_POST[fecha_registro]);
$fecha_ingreso = utf8_decode($_POST[fecha_ingreso]);
$hora_inicio = utf8_decode($_POST[hora_inicio]);
$hora_fin = utf8_decode($_POST[hora_fin]);
$motivo_ingreso = utf8_decode($_POST[motivo_ingreso]);
$observacion = utf8_decode($_POST[observacion]);
$autorizado_por = utf8_decode($_POST[autorizado_por]);
$id_usuario = utf8_decode($_POST[id_usuario]);
$estado_ingreso = 'SOLICITADO';


$ingreso_funcionario = new ingreso_funcionario();
$result = $ingreso_funcionario->registrar_ingreso_funcionario($fecha_registro, $fecha_ingreso, $hora_inicio, $hora_fin, $motivo_ingreso, $observacion, $autorizado_por, $estado_ingreso, $id_usuario);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.".$fecha_registro."-".$fecha_ingreso."-".$hora_inicio."-".$hora_fin."-".$motivo_ingreso."-".$observacion."-".$autorizado_por."-".$estado_ingreso."-".$id_usuario;
}


?>