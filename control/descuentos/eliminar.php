<?php
include("../../modelo/descuentos.php");
include("../../modelo/funciones.php");

referer_permit();


$descuentos = new descuentos();
$result = $descuentos->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>