<?php
include("../../modelo/conf_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$nombre_descuento = utf8_decode($_POST[nombre_descuento]);
$estado = utf8_decode($_POST[estado]);

$conf_descuentos = new conf_descuentos();
$result = $conf_descuentos->registrar_conf_descuentos($nombre_descuento, $estado);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocurri&oacute; un Error.";
}


?>