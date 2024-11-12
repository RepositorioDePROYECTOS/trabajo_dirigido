<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_material = $_GET[id];

$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->autorizar($id_solicitud_material);
if($result)
{
	echo "Solicitud de material Aprobado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>