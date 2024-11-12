<?php
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_material = $_GET[id];
$estado = $_GET[estado];
$fecha_registro_adquisiciones = date("Y-m-d");
$solicitud_material = new solicitud_material();
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