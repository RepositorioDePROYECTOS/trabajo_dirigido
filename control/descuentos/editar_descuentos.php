<?php
include("../../modelo/descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$id_descuentos = $_POST[id_descuentos];
$nombre_descuento = utf8_decode($_POST[nombre_descuento]);
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$monto = utf8_decode($_POST[monto]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$descuentos = new descuentos();
$result = $descuentos->modificar_descuentos($id_descuentos, $mes, $gestion, $nombre_descuento, $monto, $id_asignacion_cargo);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>