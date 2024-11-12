<?php
include("../../modelo/entrevista.php");
include("../../modelo/funciones.php");

referer_permit();


$entrevista = new Entrevista();
$result = $entrevista->eliminar_preguntas(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>