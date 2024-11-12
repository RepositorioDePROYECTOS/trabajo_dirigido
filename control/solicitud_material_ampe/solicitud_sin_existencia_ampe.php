<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();
// date_default_timezone_set('America/La_Paz');
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_solicitud_material = $_GET[id];

$fecha_solicitud = date("Y-m-d");
$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->estado_sin_existencia($id_solicitud_material,$fecha_solicitud);
if($result)
{
	echo "Solicitud de material derivado a presupuesto.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>