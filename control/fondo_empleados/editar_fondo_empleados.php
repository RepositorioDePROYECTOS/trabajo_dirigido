<?php
include("../../modelo/fondo_empleados.php");
include("../../modelo/funciones.php");

referer_permit();

$id_fondo_empleados = $_POST[id_fondo_empleados];
$pago_deuda = utf8_decode($_POST[pago_deuda]);
$monto_fe = utf8_decode($_POST[monto_fe]);
$total_fe = round(($pago_deuda + $monto_fe),2);

$fondo_empleados = new fondo_empleados();
$result = $fondo_empleados->modificar_fondo_empleados($id_fondo_empleados, $pago_deuda, $monto_fe, $total_fe);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>