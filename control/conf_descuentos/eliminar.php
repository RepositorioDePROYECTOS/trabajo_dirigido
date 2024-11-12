<?php
include("../../modelo/conf_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_descuentos = new conf_descuentos();
$result = $conf_descuentos->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>