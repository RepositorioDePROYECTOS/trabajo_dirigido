<?php
include("../../modelo/trabajador.php");
include("../../modelo/funciones.php");

referer_permit();


$trabajador = new trabajador();
$result = $trabajador->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>