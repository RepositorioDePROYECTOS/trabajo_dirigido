<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();
// date_default_timezone_set('America/La_Paz');
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_solicitud_material = $_GET[id];
$estado = $_GET[estado];
$fecha_registro_adquisiciones = date("Y-m-d");
$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->en_adquisicion($id_solicitud_material,$estado,$fecha_registro_adquisiciones);
if($result)
{
	echo "Solicitud de material en Adquisiciones.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>