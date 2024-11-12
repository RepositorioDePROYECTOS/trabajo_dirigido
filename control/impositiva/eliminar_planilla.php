<?php
include("../../modelo/impositiva.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);
$impositiva = new impositiva();
$bd = new conexion();
$registros = $bd->Consulta("select * from impositiva where mes=$mes and gestion=$gestion");
$registro = $bd->getFila($registros);
if(empty($registro))
{
	echo "No exite registros a eliminar";
}
else
{
	$result = $impositiva->eliminar_planilla($mes, $gestion);
	if($result)
	{
		echo "Acci&oacute;n completada con &eacute;xito.";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}


?>