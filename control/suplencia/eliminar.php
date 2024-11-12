<?php
include("../../modelo/suplencia.php");
include("../../modelo/funciones.php");

referer_permit();


$suplencia = new suplencia();
$result = $suplencia->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>