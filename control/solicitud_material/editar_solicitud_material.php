<?php
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");

referer_permit();
$existencia_material   = utf8_decode($_POST[existencia_material]);
$id_solicitud_material = $_POST[id_solicitud_material];
$gerente_area          = utf8_decode($_POST[gerente_area]);
$autorizado_por        = utf8_decode($_POST[autorizado_por]);
$justificativo         = utf8_decode($_POST[justificativo]);

$unidad_solicitante    = utf8_decode($_POST[unidad_solicitante]);
$objetivo_contratacion = utf8_decode($_POST[objetivo_contratacion]);
$justificacion         = utf8_decode($_POST[justificacion]);

$solicitud_material = new solicitud_material();
if ( $existencia_material == 'SI'){
	$result = $solicitud_material->modificar_solicitud_material($id_solicitud_material,$justificativo, $gerente_area, $autorizado_por );
} else {
	$result = $solicitud_material->modificar_solicitud_material_no($id_solicitud_material,$unidad_solicitante, $objetivo_contratacion, $justificacion );
}
if($result)
{
	echo "Datos actualizados.";
}
else
{
	// if ($existencia_material == 'SI') {
	// 	echo "ID: ".$id_solicitud_material.
	// 	"<br> Gerentes: ".$gerente_area.
	// 	"<br> Autorizado: ".$autorizado_por.
	// 	"<br> Justificativo: ".$justificativo;
	// } else {
	// 	echo "ID: ".$id_solicitud_material.
	// 	"<br> unidad_solicitante: ".$unidad_solicitante.
	// 	"<br> objetivo_contratacion: ".$objetivo_contratacion.
	// 	"<br> justificacion: ".$justificacion;
	// }
	echo "No se realizaron Cambios.";
}
