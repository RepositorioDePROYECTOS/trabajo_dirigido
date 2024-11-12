<?php
include("../../modelo/conf_asistencia.php");
include("../../modelo/funciones.php");

referer_permit();


$conf_asistencia = new conf_asistencia();
$result = $conf_asistencia->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>