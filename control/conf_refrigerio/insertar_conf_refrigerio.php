<?php
include("../../modelo/conf_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$descripcion = utf8_decode($_POST[descripcion]);
$monto_refrigerio = utf8_decode($_POST[monto_refrigerio]);
$estado_refrigerio = utf8_decode($_POST[estado_refrigerio]);

$conf_refrigerio = new conf_refrigerio();
$result = $conf_refrigerio->registrar_conf_refrigerio($descripcion, $monto_refrigerio, $estado_refrigerio);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocurri&oacute; un Error.";
}


?>