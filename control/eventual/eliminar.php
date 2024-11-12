<?php
include("../../modelo/eventual.php");
include("../../modelo/funciones.php");

referer_permit();


$eventual = new eventual();
$result = $eventual->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>