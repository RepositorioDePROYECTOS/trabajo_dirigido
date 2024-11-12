<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_planilla = security($_GET[id]);
$planilla = new planilla();
$bd = new conexion();
$registros = $bd->Consulta("select * from planilla where id_planilla=$id_planilla and estado_planilla='APROBADO'");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. la planilla esta aprobada. Para eliminar debe desaprobarla";
}
else
{
	$result = $planilla->eliminar();
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