<?php
include("../../modelo/conf_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_refrigerio = $_POST[id_conf_refrigerio];
$descripcion = utf8_decode($_POST[descripcion]);
$monto_refrigerio = utf8_decode($_POST[monto_refrigerio]);
$estado_refrigerio = utf8_decode($_POST[estado_refrigerio]);

$conf_refrigerio = new conf_refrigerio();
$result = $conf_refrigerio->modificar_conf_refrigerio($id_conf_refrigerio, $descripcion, $monto_refrigerio, $estado_refrigerio);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>