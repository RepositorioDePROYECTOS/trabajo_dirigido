<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_material = $_POST[id_solicitud_material];
$observacion = $_POST[observacion];

$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->rechazar_solicitud($id_solicitud_material, $observacion);
if($result)
{
	echo "Solicitud de material rechazado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>