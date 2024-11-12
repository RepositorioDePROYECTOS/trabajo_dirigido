<?php
include("../../modelo/conf_impositiva.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_impositiva = new conf_impositiva();
$result = $conf_impositiva->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>