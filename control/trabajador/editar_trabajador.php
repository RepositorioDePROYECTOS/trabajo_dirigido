<?php
include("../../modelo/trabajador.php");
include("../../modelo/formacion.php");
include("../../modelo/funciones.php");

referer_permit();

$id_trabajador = $_POST[id_trabajador];
$ci = utf8_decode($_POST[ci]);
$exp =  utf8_decode($_POST[exp]);
$nua = utf8_decode($_POST[nua]);
$nombres = utf8_decode($_POST[nombres]);
$apellido_paterno = utf8_decode($_POST[apellido_paterno]);
$apellido_materno = utf8_decode($_POST[apellido_materno]);
$direccion = utf8_decode($_POST[direccion]);
$sexo = utf8_decode($_POST[sexo]);
$nacionalidad = utf8_decode($_POST[nacionalidad]);
$fecha_nacimiento = utf8_decode($_POST[fecha_nacimiento]);
$antiguedad_anios = utf8_decode($_POST[antiguedad_anios]);
$antiguedad_meses = utf8_decode($_POST[antiguedad_meses]);
$antiguedad_dias = utf8_decode($_POST[antiguedad_dias]);
$estado_trabajador = utf8_decode($_POST[estado_trabajador]);
$grado_formacion = utf8_decode($_POST[grado_formacion]);
$titulo_academico = utf8_decode($_POST[titulo_academico]);

$trabajador = new trabajador();
$formacion = new formacion();

$result = $trabajador->modificar_trabajador($id_trabajador, $ci, $exp, $nua, $nombres, $apellido_paterno, $apellido_materno, $direccion, $sexo, $nacionalidad, $fecha_nacimiento, $antiguedad_anios, $antiguedad_meses, $antiguedad_dias, $estado_trabajador);
if($result)
{
	$result_1 = $formacion->registrar_formacion($grado_formacion,$titulo_academico,$id_trabajador);
	if($result_1)
	{
		echo "Datos actualizados.";
	}
	else
	{
		echo "Ocurri&oacute; un Error. Al registrar la Formaci&oacute;n";
	}
	
}
else
{
	echo "Ocurri&oacute; un Error.";
}


?>