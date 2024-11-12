<?php
include("../../modelo/vehiculo.php");

$id_vehiculo = $_POST[id_vehiculo];
$placa = utf8_decode($_POST[placa]);
$marca = $_POST[marca];
$modelo = $_POST[modelo];


$vehiculo = new vehiculo();
$result = $vehiculo->modificar_vehiculo($id_vehiculo, $placa, $marca, $modelo);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>