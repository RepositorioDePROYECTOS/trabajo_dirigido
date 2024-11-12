<?php
include("../../modelo/vehiculo.php");


$placa = utf8_decode($_POST[placa]);
$marca = utf8_decode($_POST[marca]);
$modelo = utf8_decode($_POST[modelo]);
$estado = 1;

$vehiculo = new vehiculo();
$result = $vehiculo->registrar_vehiculo($placa, $marca, $modelo, $estado);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error.";
}

?>
