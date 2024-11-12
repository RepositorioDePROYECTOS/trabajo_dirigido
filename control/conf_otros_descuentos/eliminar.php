<?php
include("../../modelo/conf_otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_otros_descuentos = new conf_otros_descuentos();
$result = $conf_otros_descuentos->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>