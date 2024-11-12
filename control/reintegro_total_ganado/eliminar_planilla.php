<?php
include("../../modelo/reintegro_total_ganado.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);
$reintegro_total_ganado = new reintegro_total_ganado();
$bd = new conexion();
$registros = $bd->Consulta("select * from reintegro_total_ganado where mes_reintegro=$mes and gestion_reintegro=$gestion");
$registro = $bd->getFila($registros);
if(empty($registro))
{
	echo "No exite registros a eliminar";
}
else
{
	$result = $reintegro_total_ganado->eliminar_planilla($mes, $gestion);
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