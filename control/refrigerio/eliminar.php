<?php
include("../../modelo/refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();


$refrigerio = new refrigerio();
$result = $refrigerio->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>