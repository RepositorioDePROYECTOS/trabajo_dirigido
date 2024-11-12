<?php
include("../../modelo/usuario.php");
include("../../modelo/rol.php");

$rol = new rol();


$id_usuario = $_POST[id_usuario];
$correo = $_POST[correo];
$cuenta = utf8_decode($_POST[cuenta]);
$password = md5(utf8_decode($_POST[password]));

$fecha_actualizacion = date("Y-m-d H:i:s");

$id_rol = $_POST[id_rol];

$rol->get_rol($id_rol);

$usuario = new usuario();
$result = $usuario->modificar_usuario($id_usuario, $correo, $cuenta, $password, $rol->nombre_rol, $fecha_actualizacion, $id_rol);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>