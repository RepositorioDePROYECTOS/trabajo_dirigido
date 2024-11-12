<?php
include("../../modelo/solicitud_activo_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_POST[id_solicitud_activo];
$observacion = $_POST[observacion];

$solicitud_activo = new solicitud_activo_ampe();
$result = $solicitud_activo->rechazar_solicitud($id_solicitud_activo, $observacion);
if($result)
{
	echo "Solicitud de activo rechazado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>