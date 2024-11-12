<?php
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");

referer_permit();


$solicitud_activo = new solicitud_activo();
$result = $solicitud_activo->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>