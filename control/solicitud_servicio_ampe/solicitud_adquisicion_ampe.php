<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_GET[id];
$estado = $_GET[estado];
$fecha_registro_adquisiciones = date("Y-m-d");
$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->en_adquisicion($id_solicitud_servicio,$estado,$fecha_registro_adquisiciones);
if($result)
{
	echo "Solicitud de servicio en Adquisiciones.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>