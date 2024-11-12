<?php
include("../../modelo/usuario.php");
include("../../modelo/trabajador.php");
include("../../modelo/rol.php");

$trabajador = new trabajador();
$rol = new rol();
$correo = $_POST[correo];
$cuenta = utf8_decode($_POST[cuenta]);
$password = md5(utf8_decode($_POST[password]));
$id_trabajador = utf8_decode($_POST[id_trabajador]);
$trabajador->get_trabajador($id_trabajador);
$nombre_ap = $trabajador->nombres." ".$trabajador->apellido_paterno." ".$trabajador->apellido_materno;

$fecha_registro = date("Y-m-d H:i:s");
$fecha_actualizacion = date("Y-m-d H:i:s");
$fecha_ultimo_ingreso = '';
$ip_actual = '';
$ip_ultimo = '';
$estado_usuario = 1;
$id_rol = $_POST[id_rol];
$rol->get_rol($id_rol);
$nivel = $rol->nombre_rol;




$usuario = new usuario();
$result = $usuario->registrar_usuario($correo, $cuenta, $nombre_ap, $password, $nivel, $fecha_registro, $fecha_actualizacion, $fecha_ultimo_ingreso, $ip_actual, $ip_ultimo, $estado_usuario, $id_trabajador, $id_rol);

if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El usuario ya existe.";
}

?>