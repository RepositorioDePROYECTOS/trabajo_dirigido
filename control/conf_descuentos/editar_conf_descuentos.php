<?php
include("../../modelo/conf_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$id_conf_descuentos = $_POST[id_conf_descuentos];
$nombre_descuento = utf8_decode($_POST[nombre_descuento]);
$estado = utf8_decode($_POST[estado]);

$conf_descuentos = new conf_descuentos();
$result = $conf_descuentos->modificar_conf_descuentos($id_conf_descuentos, $nombre_descuento, $estado);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>