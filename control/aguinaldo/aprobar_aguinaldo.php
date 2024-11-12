<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_aguinaldo = utf8_decode($_POST[id_aguinaldo]);

$aguinaldo = new aguinaldo();
$result = $aguinaldo->aprobar_aguinaldo($id_aguinaldo);
if($result)
{
	echo "Aguinaldo Aprobado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>