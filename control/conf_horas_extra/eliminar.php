<?php
include("../../modelo/conf_horas_extra.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_horas_extra = new conf_horas_extra();
$result = $conf_horas_extra->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>