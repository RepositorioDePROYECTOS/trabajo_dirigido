<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_nombre_planilla = security($_GET[id]);
$planilla = new planilla();
$bd = new conexion();
$registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla and estado_planilla='APROBADO'");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. Hay planillas aprobadas. Para eliminar debe desaprobarlas";
}
else
{
	$result = $planilla->eliminar_planilla($id_nombre_planilla);
	if($result)
	{
		echo "Acci&oacute;n completada con &eacute;xito.".$registro[id_planilla];
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}


?>