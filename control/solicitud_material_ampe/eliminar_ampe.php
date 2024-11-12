<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();


$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>