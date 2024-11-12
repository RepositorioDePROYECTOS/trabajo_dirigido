<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$gestion = $_REQUEST['gestion'];
$mes = $_REQUEST['mes'];

$aguinaldo = new aguinaldo();
$bd = new conexion();
$registros = $bd->Consulta("select * from aguinaldo where gestion=$gestion and mes=$mes and estado='APROBADO'");
if($bd->numFila($registros)>0)
{
	while($registro = $bd->getFila($registros))
	{
		if($registro[estado] == 'APROBADO')
		{
			$result = $aguinaldo->reprobar_aguinaldo($registro[id_aguinaldo]);
		}
		
	}
	echo "Se reprobo con exito la planilla";
}
else
{
	echo "Error. No existen planillas para aprobar";
}

?>