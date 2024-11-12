<?php
include("../../modelo/estante.php");

$id_estante = $_POST[id_estante];
$nombre = $_POST[nombre];
$id_tipo_estante = intval($_POST[id_tipo_estante]);

$estante = new estante();
$result = $estante->modificar_estante($id_estante, $nombre, $id_tipo_estante);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>