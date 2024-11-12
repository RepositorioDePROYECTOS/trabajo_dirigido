<?php
include("../../modelo/descuentos.php");

include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$nombre_descuento = utf8_decode($_POST[nombre_descuento]);
$monto = utf8_decode($_POST[monto]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$descuentos = new descuentos();
$bd = new conexion();

$registros = $bd->Consulta("select *  from descuentos where mes=$mes and gestion=$gestion and nombre_descuento='$nombre_descuento' and id_asignacion_cargo=$id_asignacion_cargo");
$registro = $bd->getFila($registros);

if($registro[id_asignacion_cargo]==$id_asignacion_cargo)
{
	echo "Error. Ya existe ese descuento registrado";
}
else
{
	$result = $descuentos->registrar_descuentos($mes, $gestion, $nombre_descuento, $monto, $id_asignacion_cargo);
	if($result)
	{
		echo "Datos registrados.";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}



?>