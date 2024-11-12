<?php
include("../../modelo/ingreso_funcionario.php");
include("../../modelo/funciones.php");

referer_permit();

$id_ingreso_funcionario = $_GET[id];

$ingreso_funcionario = new ingreso_funcionario();
$result = $ingreso_funcionario->rechazar($id_ingreso_funcionario);
if($result)
{
	echo "Ingreso rechazado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>