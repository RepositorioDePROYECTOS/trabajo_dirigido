<?php
include("../../modelo/descargo_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$id_descargo_refrigerio = $_POST[id_descargo_refrigerio];
$monto_refrigerio = utf8_decode($_POST[monto_refrigerio]);
$monto_descargo = utf8_decode($_POST[monto_descargo]);

$descargo_refrigerio = new descargo_refrigerio();

$descargo_refrigerio->get_descargo_refrigerio(id_descargo_refrigerio);
$retencion = $monto_refrigerio - $monto_descargo;

if($retencion > 0)
{
	$retencion = round($retencion*0.13,0);
	$total_refrigerio = round($monto_refrigerio - $retencion,2);
}
else
{
	$retencion = 0;
	$total_refrigerio = round($monto_refrigerio - $retencion,2);
}

$result = $descargo_refrigerio->modificar_descargo_refrigerio($id_descargo_refrigerio, $monto_descargo, $retencion, $total_refrigerio);

if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>