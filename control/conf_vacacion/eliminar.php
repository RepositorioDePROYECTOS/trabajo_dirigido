<?php
include("../../modelo/conf_bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_bono_antiguedad = new conf_bono_antiguedad();
$result = $conf_bono_antiguedad->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>