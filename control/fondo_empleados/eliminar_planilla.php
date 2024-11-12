<?php
include("../../modelo/fondo_empleados.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);
$fondo_empleados = new fondo_empleados();
$bd = new conexion();
$registros = $bd->Consulta("select * from fondo_empleados where mes=$mes and gestion=$gestion");
$registro = $bd->getFila($registros);
if(empty($registro))
{
	echo "No exite registros a eliminar";
}
else
{
	$result = $fondo_empleados->eliminar_planilla($mes, $gestion);
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