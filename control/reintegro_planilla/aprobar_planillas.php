<?php
include("../../modelo/reintegro_planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$gestion = $_GET[gestion];
$mes = $_GET[mes];
$reintegro_planilla = new reintegro_planilla();
$bd = new conexion();
$registros = $bd->Consulta("select * from reintegro_planilla where gestion_reintegro=$gestion and mes_reintegro=$mes and estado_planilla_reintegro <> 'APROBADO'");
if($bd->numFila($registros)>0)
{
	while($registro = $bd->getFila($registros))
	{
		if($registro[estado_planilla] != 'APROBADO')
		{
			$result = $reintegro_planilla->aprobar_reintegro_planilla($registro[id_planilla_reintegro]);
		}
		
	}
	echo "Se aprobaron con exito la planilla";
}
else
{
	echo "Error. No existen planillas para aprobar";
}

?>