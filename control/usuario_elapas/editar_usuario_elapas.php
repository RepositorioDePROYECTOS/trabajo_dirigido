<?php
include("../../modelo/usuario_externo.php");
include("../../modelo/expediente.php");

$id_user_ex = $_POST[id_user_ex];
$nombre = $_POST[nombre];
$documento = $_POST[documento];
$direccion = $_POST[direccion];

$id_expediente = $_POST[id_expediente];
$nr_fojas = $_POST[nr_fojas];
$codigo_catastral = $_POST[codigo_catastral];

$expediente = new expediente();
$result2 = $expediente->modificar_expediente($id_expediente, $nr_fojas, $codigo_catastral);

$usuario_externo = new usuario_externo();
$result = $usuario_externo->modificar_usuario_externo($id_user_ex, $nombre, $documento, $direccion);

if($result || $result2){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>