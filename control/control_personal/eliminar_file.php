<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
$bd = new conexion();
referer_permit();

$id = security($_GET[id]);
$result = $bd->Consulta("DELETE FROM files WHERE id_file = $id");
if($bd->numFila_afectada($result)>0)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>