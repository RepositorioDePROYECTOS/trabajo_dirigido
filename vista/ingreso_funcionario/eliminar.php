<?php
include("../../modelo/ingreso_funcionario.php");
include("../../modelo/funciones.php");

referer_permit();


$ingreso_funcionario = new ingreso_funcionario();
$result = $ingreso_funcionario->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>