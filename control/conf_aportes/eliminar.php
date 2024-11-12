<?php
include("../../modelo/conf_aportes.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_aportes = new conf_aportes();
$result = $conf_aportes->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>