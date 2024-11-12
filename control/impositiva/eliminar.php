<?php
include("../../modelo/impositiva.php");
include("../../modelo/funciones.php");

referer_permit();


$impositiva = new impositiva();
$result = $impositiva->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>