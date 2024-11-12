<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$gestion = $_REQUEST['gestion'];
$nro_aguinaldo = $_REQUEST['nro_aguinaldo'];

$aguinaldo = new aguinaldo();
$bd = new conexion();
$registros = $bd->Consulta("select * from aguinaldo where gestion=$gestion and nro_aguinaldo=$nro_aguinaldo and estado='APROBADO'");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. Hay planillas aprobadas. Para eliminar debe desaprobarlas";
}
else
{
	$result = $aguinaldo->eliminar_aguinaldo($gestion, $nro_aguinaldo);
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