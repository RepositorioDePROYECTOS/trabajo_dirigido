<?php
include("../../modelo/partidas_detalle.php");

$id_partida_detalle   = $_POST[id_partida_detalle];
$concepto_partida     = utf8_decode($_POST[concepto_partida]);
$tipo_detalle_partida = utf8_decode($_POST[tipo_detalle_partida]);

$partida = new Partidas_detalle();
$result = $partida->modificar_partida_detalle($id_partida_detalle, $concepto_partida, $tipo_detalle_partida);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error.";
}

?>