<?php
include("../../modelo/aporte_laboral.php");
include("../../modelo/funciones.php");

referer_permit();

$id_aporte_laboral = $_POST[id_aporte_laboral];
$monto_aporte = utf8_decode($_POST[monto_aporte]);

$aporte_laboral = new aporte_laboral();
$result = $aporte_laboral->modificar_aporte_laboral($id_aporte_laboral, $monto_aporte);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>