<?php
include("../../modelo/bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();

$id_bono_antiguedad = $_POST[id_bono_antiguedad];

$monto = utf8_decode($_POST[monto]);

$bono_antiguedad = new bono_antiguedad();
$result = $bono_antiguedad->modificar_bono_antiguedad($id_bono_antiguedad, $monto);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>