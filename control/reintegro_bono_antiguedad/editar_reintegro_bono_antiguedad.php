<?php
include("../../modelo/reintegro_bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();

$id_reintegro_bono_antiguedad = $_POST[id_reintegro_bono_antiguedad];

$monto_reintegro = utf8_decode($_POST[monto_reintegro]);

$reintegro_bono_antiguedad = new reintegro_bono_antiguedad();
$result = $reintegro_bono_antiguedad->modificar_reintegro_bono_antiguedad($id_reintegro_bono_antiguedad, $monto_reintegro);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>