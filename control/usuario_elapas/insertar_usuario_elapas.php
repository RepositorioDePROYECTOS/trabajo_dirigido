<?php
include("../../modelo/usuario_elapas.php");


$codigo_catastral_actual = $_POST[codigo_catastral_actual];
$codigo_catastral_antiguo = $_POST[codigo_catastral_antiguo];
$numero_cuenta = $_POST[numero_cuenta];
$nombre_usuario = $_POST[nombre_usuario];
$documento = $_POST[documento];
$direccion = $_POST[direccion];
$categoria = $_POST[categoria];
$paralelo = $_POST[paralelo];
$codigo_catastral_origen = $_POST[codigo_catastral_origen];
$numero_cuenta_origen = $_POST[numero_cuenta_origen];
$estado = $_POST[estado];

$usuario_elapas = new usuario_elapas();
$result = $usuario_elapas->registrar_usuario_elapas($codigo_catastral_actual, $codigo_catastral_antigua, $numero_cuenta, $nombre_usuario, $documento, $direccion, $categoria, $paralelo, $codigo_catastral_origen, $numero_cuenta_origen, $estado);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El usuario ya existe.";
}

?>