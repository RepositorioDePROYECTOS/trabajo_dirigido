<?php
include("../../modelo/conf_bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();

$anio_i = utf8_decode($_POST[anio_i]);
$anio_f = utf8_decode($_POST[anio_f]);
$porcentaje = utf8_decode($_POST[porcentaje]);
$estado_bono = utf8_decode($_POST[estado_bono]);

$conf_bono_antiguedad = new conf_bono_antiguedad();
$result = $conf_bono_antiguedad->registrar_conf_bono_antiguedad($anio_i, $anio_f, $porcentaje, $estado_bono);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>