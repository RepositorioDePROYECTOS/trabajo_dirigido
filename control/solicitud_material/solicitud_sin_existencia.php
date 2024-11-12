<?php
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_material = $_GET[id];

$fecha_solicitud = date("Y-m-d");
$solicitud_material = new solicitud_material();
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