<?php
include("../../modelo/solicitud_activo_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_GET[id];

$solicitud_activo = new solicitud_activo_ampe();
$result = $solicitud_activo->autorizar($id_solicitud_activo);
if($result)
{
	echo "Solicitud de activo Aprobado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>