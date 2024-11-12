<?php
include("../../modelo/solicitud_servicio.php");
include("../../modelo/funciones.php");

referer_permit();


$solicitud_servicio = new solicitud_servicio();
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