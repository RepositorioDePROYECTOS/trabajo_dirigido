<?php
include("../../modelo/solicitud_activo_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_GET[id];
$estado = $_GET[estado];

$solicitud_activo = new solicitud_activo_ampe();
$result = $solicitud_activo->presupuestar($id_solicitud_activo,$estado);
if($result)
{
	echo "Solicitud de activo modificado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>