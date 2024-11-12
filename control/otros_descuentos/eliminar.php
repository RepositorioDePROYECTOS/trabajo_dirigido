<?php
include("../../modelo/otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();


$otros_descuentos = new otros_descuentos();
$result = $otros_descuentos->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>