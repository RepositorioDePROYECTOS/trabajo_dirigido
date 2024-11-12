<?php
include("../../modelo/caja.php");

$id_caja = $_POST[id_caja];
$codigo = utf8_decode($_POST[codigo]);
$id_estante = intval($_POST[id_estante]);

$caja = new caja();
$result = $caja->modificar_caja($id_caja, $codigo, $id_estante);
if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>