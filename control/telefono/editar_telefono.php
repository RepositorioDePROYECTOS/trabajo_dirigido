<?php
include("../../modelo/telefono.php");

$id_telefono = $_POST[id_telefono];
$id_trabajador = intval($_POST[id_trabajador]);
$telf_interno = $_POST[telf_interno];

$telefono = new telefono();
$result = $telefono->modificar_telefono($id_telefono, $id_trabajador, $telf_interno);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
    //echo $id_usuario."<br>".$cuenta."<br>".$password."<br>".$fecha_actualizacion."<br>".$nivel;
}
?>
