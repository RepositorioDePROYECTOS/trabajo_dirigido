<?php
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_GET[id];

$fecha_solicitud = date("Y-m-d");
$solicitud_activo = new solicitud_activo();
$result = $solicitud_activo->estado_sin_existencia($id_solicitud_activo,$fecha_solicitud);
if($result)
{
	echo "Solicitud de activo derivado a presupuesto.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>