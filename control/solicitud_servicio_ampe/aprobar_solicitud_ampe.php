<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_GET[id];

$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->autorizar($id_solicitud_servicio);
if($result)
{
	echo "Solicitud de servicio Aprobado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>