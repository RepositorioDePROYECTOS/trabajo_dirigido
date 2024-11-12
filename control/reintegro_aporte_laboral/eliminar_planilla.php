<?php
include("../../modelo/reintegro_aporte_laboral.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);
$reintegro_aporte_laboral = new reintegro_aporte_laboral();
$bd = new conexion();
$registros = $bd->Consulta("select * from reintegro_aporte_laboral where mes_reintegro=$mes and gestion_reintegro=$gestion");
$registro = $bd->getFila($registros);
if(empty($registro))
{
	echo "No exite registros a eliminar";
}
else
{
	$result = $reintegro_aporte_laboral->eliminar_planilla($mes, $gestion);
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