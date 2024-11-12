<?php
include("../../modelo/total_ganado.php");
include("../../modelo/funciones.php");

referer_permit();

$id_total_ganado = $_POST[id_total_ganado];
$total_dias = utf8_decode($_POST[total_dias]);
$haber_basico = utf8_decode($_POST[salario_basico]);

$total_ganado = new total_ganado();
$total_ganado->get_total_ganado($id_total_ganado);




$total_gan = $haber_basico + $total_ganado->bono_antiguedad + $total_ganado->monto_horas_extra + $total_ganado->suplencia;

$result = $total_ganado->modificar_total_ganado($id_total_ganado, $total_dias, $haber_basico, $total_gan);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>