<?php
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();


$asistencia = new asistencia();
$result = $asistencia->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>