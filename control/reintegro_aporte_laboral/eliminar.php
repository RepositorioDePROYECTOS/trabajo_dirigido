<?php
include("../../modelo/aporte_laboral.php");
include("../../modelo/funciones.php");

referer_permit();


$aporte_laboral = new aporte_laboral();
$result = $aporte_laboral->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>