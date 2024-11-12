<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();


$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>