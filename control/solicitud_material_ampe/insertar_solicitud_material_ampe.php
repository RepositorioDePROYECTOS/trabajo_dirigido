<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_solicitud               = utf8_decode($_POST[fecha_solicitud]);
$programa_solicitud_material   = utf8_decode($_POST[programa_solicitud_material]);
$actividad_solicitud_material  = utf8_decode($_POST[actividad_solicitud_material]);
$oficina_solicitante           = utf8_decode($_POST[oficina_solicitante]);
$item_solicitante              = utf8_decode($_POST[item_solicitante]);
$nombre_solicitante            = utf8_decode($_POST[nombre_solicitante]);
$justificativo                 = utf8_decode(strtoupper($_POST[justificativo]));
$onjetivo_contratacion         = 'ANPE';
$autorizado_por                = utf8_decode($_POST[autorizado_por]);
$visto_bueno                   = utf8_decode($_POST[visto_bueno]);
$gerente_area                  = utf8_decode($_POST[gerente_area]);
$existencia_material           = utf8_decode($_POST[existencia_material]);
$estado_solicitud_material     = 'SOLICITADO';
$id_usuario                    = utf8_decode($_POST[id_usuario]);

$solicitud_material = new solicitud_material_ampe();
$bd = new conexion();
$registros = $bd->Consulta("select max(nro_solicitud_material) as nro_solicitud from solicitud_material");
$registro = $bd->getFila($registros);
$nro_solicitud_material = $registro[nro_solicitud] + 1;
$result = $solicitud_material->registrar_solicitud_material(
		$nro_solicitud_material,
		$fecha_solicitud, 
		$programa_solicitud_material, 
		$actividad_solicitud_material, 
		$oficina_solicitante, 
		$item_solicitante, 
		$nombre_solicitante, 
		$justificativo, 
		$onjetivo_contratacion,
		$autorizado_por, 
		$visto_bueno, 
		$gerente_area, 
		$existencia_material, 
		$estado_solicitud_material, 
		$id_usuario);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error. nro: ".$nro_solicitud_material."- Fecha: ".
	$fecha_solicitud."- Programa: ".
	$programa_solicitud_material."- Actividad: ".
	$actividad_solicitud_material."- Oficina".
	$oficina_solicitante."-".
	$item_solicitante."-".
	$nombre_solicitante."-".
	$justificativo."-".
	$autorizado_por."-".
	$visto_bueno."-".
	$gerente_area."- existe: ".
	$existencia_material."-".
	$estado_solicitud_material."-".
	$id_usuario;
}


?>