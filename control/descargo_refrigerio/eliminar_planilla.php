<?php
include("../../modelo/descargo_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);
$descargo_refrigerio = new descargo_refrigerio();
$bd = new conexion();
$registros = $bd->Consulta("select * from descargo_refrigerio where mes=$mes and gestion=$gestion");
$registro = $bd->getFila($registros);
if(empty($registro))
{
	echo "No exite registros a eliminar";
}
else
{
	$result = $descargo_refrigerio->eliminar_planilla($mes, $gestion);
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