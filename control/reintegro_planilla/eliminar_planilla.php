<?php
include("../../modelo/reintegro_planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$gestion = security($_GET[gestion]);
$mes = security($_GET[mes]);
$reintegro_planilla = new reintegro_planilla();
$bd = new conexion();
$registros = $bd->Consulta("select * from reintegro_planilla where gestion_reintegro=$gestion and mes_reintegro=$mes and estado_planilla_reintegro='APROBADO'");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. Hay planillas aprobadas. Para eliminar debe desaprobarlas";
}
else
{
	$result = $reintegro_planilla->eliminar_reintegro_planilla($gestion, $mes);
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