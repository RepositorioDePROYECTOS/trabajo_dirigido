<?php
include("../../modelo/solicitud_activo_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_activo = $_POST[id_solicitud_activo];
$gerente_area = utf8_decode($_POST[gerente_area]);
$autorizado_por = utf8_decode($_POST[autorizado_por]);
$justificativo = utf8_decode(mb_strtoupper($_POST[justificativo]));


$solicitud_activo = new solicitud_activo_ampe();
$result = $solicitud_activo->modificar_solicitud_activo($id_solicitud_activo,$justificativo, $gerente_area, $autorizado_por );
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>