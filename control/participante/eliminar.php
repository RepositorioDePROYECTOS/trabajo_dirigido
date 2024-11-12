<?php
include("../../modelo/participante.php");
include("../../modelo/funciones.php");

referer_permit();


$postulante = new Postulante();
$result = $postulante->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>