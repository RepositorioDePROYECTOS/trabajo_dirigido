<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_nombre_planilla = $_GET[id];

$planilla = new planilla();
$bd = new conexion();
$registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla and estado_planilla='APROBADO'");
if($bd->numFila($registros)>0)
{
	while($registro = $bd->getFila($registros))
	{
		if($registro[estado_planilla] == 'APROBADO')
		{
			$result = $planilla->reprobar_planilla($registro[id_planilla]);
		}
		
	}
	echo "Se reprobo con exito la planilla";
}
else
{
	echo "Error. No existen planillas para aprobar";
}

?>