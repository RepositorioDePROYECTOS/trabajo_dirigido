<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_aguinaldo = utf8_decode($_POST[id]);

$aguinaldo = new aguinaldo();
$bd = new conexion();
$registros = $bd->Consulta("select * from aguinaldo where id_aguinaldo=$id_aguinaldo and estado='APROBADO'");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. la planilla esta aprobada. Para eliminar debe desaprobarla";
}
else
{
	$result = $aguinaldo->eliminar($id_aguinaldo);
	if($result)
	{
		echo "Acci&oacute;n completada con &eacute;xito";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}

?>