<?php
include("../../modelo/otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$id_otros_descuentos = $_POST[id_otros_descuentos];
$descripcion = utf8_decode($_POST[descripcion]);
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$monto_od = utf8_decode($_POST[monto_od]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$otros_descuentos = new otros_descuentos();
$result = $otros_descuentos->modificar_otros_descuentos($id_otros_descuentos, $monto_od);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>