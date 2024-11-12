<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$numero_mes = utf8_decode($_POST[numero_mes]);
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$item = utf8_decode($_POST[item]);
$ci = utf8_decode($_POST[ci]);
$nombres = utf8_decode($_POST[nombres]);
$apellidos = utf8_decode($_POST[apellidos]);
$cargo = utf8_decode($_POST[cargo]);
$fecha_ingreso = utf8_decode($_POST[fecha_ingreso]);
$dias_pagado = utf8_decode($_POST[dias_pagado]);
$haber_basico = utf8_decode($_POST[haber_basico]);
$bono_antiguedad = utf8_decode($_POST[bono_antiguedad]);
$extras = utf8_decode($_POST[extras]);
$total_ganado = utf8_decode($_POST[total_ganado]);
$descuentos_afp = utf8_decode($_POST[descuentos_afp]);
$descuentos_rciva = utf8_decode($_POST[descuentos_rciva]);
$descuento = utf8_decode($_POST[descuento]);
$multas = utf8_decode($_POST[multas]);
$total_descuentos = utf8_decode($_POST[total_descuentos]);
$liquido_pagable = utf8_decode($_POST[liquido_pagable]);
$estado_planilla = utf8_decode($_POST[estado_planilla]);

$planilla = new planilla();
$result = $planilla->registrar_planilla($numero_mes, $mes, $gestion, $item, $ci, $nombres, $apellidos, $cargo, $fecha_ingreso, $dias_pagado, $haber_basico, $bono_antiguedad, $extras, $total_ganado, $descuentos_afp, $descuentos_rciva, $descuento, $multas, $total_descuentos, $liquido_pagable, $estado_planilla);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>