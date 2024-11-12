<?php
include("../../modelo/solicitud_servicio_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_POST[id_solicitud_servicio];
$gerente_area = utf8_decode($_POST[gerente_area]);
$autorizado_por = utf8_decode($_POST[autorizado_por]);
$justificativo = utf8_decode(mb_strtoupper($_POST[justificativo]));


$solicitud_servicio = new solicitud_servicio_ampe();
$result = $solicitud_servicio->modificar_solicitud_servicio($id_solicitud_servicio,$justificativo, $gerente_area, $autorizado_por );
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>