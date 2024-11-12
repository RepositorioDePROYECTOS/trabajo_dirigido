<?php
include("../../modelo/cargo.php");
include("../../modelo/funciones.php");

referer_permit();


$cargo = new cargo();
$result = $cargo->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>