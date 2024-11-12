<?php
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_solicitud           = utf8_decode($_POST[fecha_solicitud]);
$oficina_solicitante       = utf8_decode($_POST[oficina_solicitante]);
$unidad_solicitante        = utf8_decode($_POST[unidad_solicitante]);
$item_solicitante          = utf8_decode($_POST[item_solicitante]);
$nombre_solicitante        = utf8_decode($_POST[nombre_solicitante]);
$justificativo             = utf8_decode($_POST[justificativo]);
$justificacion             = utf8_decode($_POST[justificacion]);
$objetivo_contratacion     = utf8_decode($_POST[objetivo_contratacion]);
$autorizado_por            = utf8_decode($_POST[autorizado_por]);
$gerente_area              = utf8_decode($_POST[gerente_area]);
$existencia_material       = utf8_decode($_POST[existencia_material]);
$estado_solicitud_material = 'SOLICITADO';
// $tipo_solcitud             = utf8_decode($_POST[tipo_solicitud]);
$id_usuario                = utf8_decode($_POST[id_usuario]);

$solicitud_material = new solicitud_material();
$bd = new conexion();
$registros = $bd->Consulta("select max(nro_solicitud_material) as nro_solicitud from solicitud_material");
$registro = $bd->getFila($registros);
$nro_solicitud_material = $registro[nro_solicitud] + 1;

if($existencia_material == 'SI'){
	$result = $solicitud_material->registrar_solicitud_material($nro_solicitud_material, $fecha_solicitud, $oficina_solicitante, $item_solicitante, $nombre_solicitante, $justificativo, $autorizado_por, $gerente_area, $existencia_material, $estado_solicitud_material, $id_usuario);
} else {
	$result = $solicitud_material->registrar_solicitud_material_no($nro_solicitud_material, $fecha_solicitud, $unidad_solicitante, $item_solicitante, $nombre_solicitante, $justificacion, $objetivo_contratacion, $existencia_material, $estado_solicitud_material, $id_usuario);
}
if($result)
{
	echo "Datos registrados.";
}
else
{
	if($existencia_material == 'SI'){
		echo "Error al registrar material con Existencia!";
		// echo "INSERT INTO solicitud_material (
		// 	nro_solicitud_material,
		// 	fecha_solicitud, 
		// 	oficina_solicitante,
		// 	item_solicitante, 
		// 	nombre_solicitante,
		// 	justificativo,
		// 	autorizado_por, 
		// 	gerente_area, 
		// 	existencia_material, 
		// 	estado_solicitud_material, 
		// 	id_usuario
		// 	) values(
		// 	'$nro_solicitud_material',
		// 	'$fecha_solicitud', 
		// 	'$oficina_solicitante',
		// 	'$item_solicitante', 
		// 	'$nombre_solicitante',
		// 	'$justificativo',
		// 	'$autorizado_por', 
		// 	'$gerente_area', 
		// 	'$existencia_material', 
		// 	'$estado_solicitud_material', 
		// 	'$id_usuario')";
	} else {
		echo "Error al registrar material sin existencia!";
		// echo "INSERT INTO solicitud_material (
		// 	nro_solicitud_material, fecha_solicitud, unidad_solicitante, item_solicitante, nombre_solicitante, justificativo,  objetivo_contratacion, existencia_material,  estado_solicitud_material, id_usuario) values(
		// 	'$nro_solicitud_material','$fecha_solicitud','$unidad_solicitante','$item_solicitante', '$nombre_solicitante','$justificacion', '$objetivo_contratacion','$existencia_material', '$estado_solicitud_material', '$id_usuario')";
	}
}


?>