<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_GET[id];
$estado = $_GET[estado];

$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->presupuestar($id_solicitud_servicio,$estado);
if($result)
{
	echo "Solicitud de servicio modificado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>