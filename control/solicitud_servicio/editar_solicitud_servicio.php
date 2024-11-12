<?php
include("../../modelo/solicitud_servicio.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_servicio = $_POST[id_solicitud_servicio];
$gerente_area          = utf8_decode($_POST[gerente_area]);
$autorizado_por        = utf8_decode($_POST[autorizado_por]);
$justificativo         = utf8_decode($_POST[justificativo]);
$objetivo_contratacion = utf8_decode($_POST[objetivo_contratacion]);


$solicitud_servicio = new solicitud_servicio();
$result = $solicitud_servicio->modificar_solicitud_servicio($id_solicitud_servicio, $justificativo, $objetivo_contratacion, $gerente_area, $autorizado_por );
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>