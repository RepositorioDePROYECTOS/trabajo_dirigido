<?php
include("../../modelo/nombre_planilla.php");
include("../../modelo/funciones.php");

referer_permit();


$nombre_planilla = new nombre_planilla();
$result = $nombre_planilla->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>