<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_aguinaldo = $_POST[id_aguinaldo];
$sueldo_1 = utf8_decode($_POST[sueldo_1]);
$sueldo_2 = utf8_decode($_POST[sueldo_2]);
$sueldo_3 = utf8_decode($_POST[sueldo_3]);


$aguinaldo = new aguinaldo();
$aguinaldo->get_aguinaldo($id_aguinaldo);

$meses = $aguinaldo->meses;

$total = $sueldo_1 + $sueldo_2 + $sueldo_3;
$dias_total = $aguinaldo->dias + ($meses * 30);

if($meses > 3)
{
	$promedio_3_meses = $total/3;
}
else
{
	$numero = $meses - 1;
	$promedio_3_meses = $total/$numero;
}

$aguinaldo_anual = $promedio_3_meses;
$aguinaldo_pagar = ($aguinaldo_anual/360) * $dias_total;


$result = $aguinaldo->modificar_aguinaldo($id_aguinaldo, $sueldo_1, $sueldo_2, $sueldo_3, $total, $promedio_3_meses, $aguinaldo_anual, $aguinaldo_pagar);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>