<?php
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");

referer_permit();

$existencia_activo        = utf8_decode($_POST[existencia_activo]);
$id_solicitud_activo      = $_POST[id_solicitud_activo];
$gerente_area             = utf8_decode($_POST[gerente_area]);
$autorizado_por           = utf8_decode($_POST[autorizado_por]);
$justificativo            = utf8_decode($_POST[justificativo]);
$unidad_solicitante       = utf8_decode($_POST[unidad_solicitante]);
$objetivo_contratacion    = utf8_decode($_POST[objetivo_contratacion]);
$justificacion            = utf8_decode($_POST[justificacion]);

// echo $unidad_solicitante." ".$objetivo_contratacion." ".$justificacion;
$solicitud_activo = new solicitud_activo();
if($existencia_activo == 'SI'){
	$result = $solicitud_activo->modificar_solicitud_activo($id_solicitud_activo,$justificativo, $gerente_area, $autorizado_por );
} else {
	$result = $solicitud_activo->modificar_solicitud_activo_no($id_solicitud_activo,$unidad_solicitante, $objetivo_contratacion, $justificacion );
}
if($result)
{
	echo "Datos actualizados.";
}
else
{
	// echo "UPDATE solicitud_activo set unidad_solicitante='$unidad_solicitante', objetivo_contratacion='$objetivo_contratacion', justificativo='$justificacion' where id_solicitud_activo=$id_solicitud_activo";
	echo "No se realizaron Cambios.";
}


?>