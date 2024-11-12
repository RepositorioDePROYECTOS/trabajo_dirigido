<?php
include("../../modelo/impositiva.php");
include("../../modelo/funciones.php");

referer_permit();

$id_impositiva = $_POST[id_impositiva];
$facturas_p = utf8_decode($_POST[presentacion_desc]);
$saldo_mes_anterior = utf8_decode($_POST[saldo_mes_anterior]);
$impositiva = new impositiva();
$bd = new conexion();
$impositiva->get_impositiva($id_impositiva);

$registros_imp = $bd->Consulta("select * from conf_impositiva where estado='HABILITADO'");
$registro_imp = $bd->getFila($registros_imp);

$mes = $impositiva->mes;
$gestion = $impositiva->gestion;
$ufv_actual = $impositiva->ufv_actual;
$ufv_pasado = $impositiva->ufv_pasado;
$total_ganado = $impositiva->total_ganado;
$aportes_laborales = $impositiva->aportes_laborales;
$sueldo_neto = $impositiva->sueldo_neto;
$minimo_no_imponible = $impositiva->minimo_no_imponible;
$base_imponible = $impositiva->base_imponible;
$impuesto_bi = $impositiva->impuesto_bi;
$presentacion_desc = $facturas_p;
$impuesto_mn = $impositiva->impuesto_mn;
$saldo_dependiente = $presentacion_desc + $impuesto_mn;
$saldo_fisco = $impositiva->saldo_fisco;
//saldo mes anterior cargamos desde formulario ya lo tenemos declarado arriba
$actualizacion = (($saldo_mes_anterior*$ufv_actual)/$ufv_pasado)-$saldo_mes_anterior;
$saldo_total_mes_anterior = $saldo_mes_anterior + $actualizacion;
$saldo_total_dependiente = $saldo_dependiente + $saldo_total_mes_anterior;
$saldo_utilizado = $impositiva->saldo_utilizado;
if($saldo_total_dependiente >= $saldo_fisco)
{
	$retencion_pagar = 0;
}
else
{
	$retencion_pagar = round(($saldo_fisco - $saldo_total_dependiente),0);
}
if($saldo_total_dependiente > $saldo_fisco)
{
	$saldo_siguiente_mes = $saldo_total_dependiente - $saldo_fisco;
}
else
{
	$saldo_siguiente_mes = 0;
}
$id_asignacion_cargo = $impositiva->id_asignacion_cargo;

$result = $impositiva->modificar_impositiva($id_impositiva, $mes, $gestion, $ufv_actual, $ufv_pasado, $total_ganado, $aportes_laborales, $sueldo_neto, $minimo_no_imponible, $base_imponible, $impuesto_bi, $presentacion_desc, $impuesto_mn, $saldo_dependiente, $saldo_fisco, $saldo_mes_anterior, $actualizacion, $saldo_total_mes_anterior, $saldo_total_dependiente, $saldo_utilizado, round($retencion_pagar,0), $saldo_siguiente_mes, $id_asignacion_cargo);

if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>