<?php
include("../../modelo/lavado.php");
include("../../modelo/vehiculo.php");

$id_vehiculo = utf8_decode($_POST[id_vehiculo]);
$vehiculo = new vehiculo();
$vehiculo->get_vehiculo($id_vehiculo);

$id_lavado = $_POST[id_lavado];
$jefatura = utf8_decode($_POST[jefatura]);
$gerencia = utf8_decode($_POST[gerencia]);



$lavado = new lavado();
$result = $lavado->modificar_lavado($id_lavado,  $vehiculo->marca, $vehiculo->modelo, $vehiculo->placa, $jefatura, $gerencia);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>