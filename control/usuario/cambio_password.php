<?php
include("../../modelo/usuario.php");
include("../../modelo/rol.php");

$usuario = new usuario();


$id_usuario = $_POST[id_usuario];
$password = md5(utf8_decode($_POST[password]));

$result = $usuario->modificar_password($id_usuario, $password);
if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>