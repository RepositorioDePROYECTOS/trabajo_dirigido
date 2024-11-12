<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_planilla = $_POST[id_planilla];
$dias_pagado = utf8_decode($_POST[dias_pagado]);
$bono_antiguedad = utf8_decode($_POST[bono_antiguedad]);
$extras = utf8_decode($_POST[extras]);
$total_ganado = utf8_decode($_POST[total_ganado]);
$descuentos_afp = utf8_decode($_POST[descuentos_afp]);
$descuentos_rciva = utf8_decode($_POST[descuentos_rciva]);
$descuento = utf8_decode($_POST[descuento]);
$multas = utf8_decode($_POST[multas]);
$total_descuentos = utf8_decode($_POST[total_descuentos]);
$liquido_pagable = utf8_decode($_POST[liquido_pagable]);
$estado_planilla = 'APROBADO';

$planilla = new planilla();
$result = $planilla->modificar_planilla($id_planilla, $dias_pagado, $bono_antiguedad, $extras, $total_ganado, $descuentos_afp, $descuentos_rciva, $descuento, $multas, $total_descuentos, $liquido_pagable, $estado_planilla);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>