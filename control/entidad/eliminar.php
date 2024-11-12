<?php
include("../../modelo/entidad.php");
include("../../modelo/funciones.php");

referer_permit();


$entidad = new entidad();
$result = $entidad->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>