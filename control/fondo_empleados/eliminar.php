<?php
include("../../modelo/fondo_empleados.php");
include("../../modelo/funciones.php");

referer_permit();


$fondo_empleados = new fondo_empleados();
$result = $fondo_empleados->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>