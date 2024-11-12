<?php
include("../../modelo/asignacion_cargo.php");
include("../../modelo/funciones.php");

referer_permit();


$asignacion_cargo = new asignacion_cargo();
$result = $asignacion_cargo->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>