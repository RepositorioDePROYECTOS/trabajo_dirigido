<?php
include("../../modelo/horas_extra.php");
include("../../modelo/funciones.php");

referer_permit();


$horas_extra = new horas_extra();
$result = $horas_extra->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>