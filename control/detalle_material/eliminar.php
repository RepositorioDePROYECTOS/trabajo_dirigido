<?php
include("../../modelo/detalle_vacacion.php");
include("../../modelo/funciones.php");

referer_permit();


$detalle_vacacion = new detalle_vacacion();
$result = $detalle_vacacion->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>