<?php
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_GET[id];
$estado = $_GET[estado];
$fecha_registro_adquisiciones = date("Y-m-d");
$solicitud_activo = new solicitud_activo();
$result = $solicitud_activo->en_adquisicion($id_solicitud_activo,$estado,$fecha_registro_adquisiciones);
if($result)
{
	echo "Solicitud de activo en Adquisiciones.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>