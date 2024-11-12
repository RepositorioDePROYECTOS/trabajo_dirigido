<?php
include("../../modelo/bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();


$bono_antiguedad = new bono_antiguedad();
$result = $bono_antiguedad->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>