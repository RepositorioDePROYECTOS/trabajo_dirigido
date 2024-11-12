<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_POST[id_solicitud_servicio];
$observacion = $_POST[observacion];

$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->rechazar_solicitud($id_solicitud_servicio, $observacion);
if($result)
{
	echo "Solicitud de servicio rechazado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>