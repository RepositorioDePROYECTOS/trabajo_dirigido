<?php
include("../../modelo/lavado.php");
include("../../modelo/vehiculo.php");

$id_vehiculo = utf8_decode($_POST[id_vehiculo]);
$vehiculo = new vehiculo();
$vehiculo->get_vehiculo($id_vehiculo);

$fecha_solicitud = utf8_decode($_POST[fecha_solicitud]);

$gerencia = utf8_decode($_POST[gerencia]);
$jefatura = utf8_decode($_POST[jefatura]);
$id_usuario = utf8_decode($_POST[id_usuario]);
$estado_lavado = "SOLICITADO";

$lavado = new lavado();
$result = $lavado->registrar_lavado($fecha_solicitud, $vehiculo->marca, $vehiculo->modelo, $vehiculo->placa, $jefatura, $gerencia, $estado_lavado, $id_usuario);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error.";
}

?>
