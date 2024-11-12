<?php
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_solicitud            = utf8_decode($_POST[fecha_solicitud]);
$oficina_solicitante        = utf8_decode($_POST[oficina_solicitante]);
$unidad_solicitante         = utf8_decode($_POST[unidad_solicitante]);
$item_solicitante           = utf8_decode($_POST[item_solicitante]);
$nombre_solicitante         = utf8_decode($_POST[nombre_solicitante]);
$justificativo              = utf8_decode($_POST[justificativo]);
$justificacion              = utf8_decode($_POST[justificacion]);
$objetivo_contratacion      = utf8_decode($_POST[objetivo_contratacion]);
$autorizado_por             = utf8_decode($_POST[autorizado_por]);
$gerente_area               = utf8_decode($_POST[gerente_area]);
$existencia_activo          = utf8_decode($_POST[existencia_activo]);
$estado_solicitud_activo    = 'SOLICITADO';
// $tipo_solcitud              = utf8_decode($_POST[tipo_solicitud]);
$id_usuario                 = utf8_decode($_POST[id_usuario]);

$solicitud_activo = new solicitud_activo();
$bd = new conexion();
$registros = $bd->Consulta("select max(nro_solicitud_activo) as nro_solicitud from solicitud_activo");
$registro = $bd->getFila($registros);
$nro_solicitud_activo = $registro[nro_solicitud] + 1;

if($existencia_activo == 'SI'){
	$result = $solicitud_activo->registrar_solicitud_activo($nro_solicitud_activo,$fecha_solicitud, $oficina_solicitante, $item_solicitante, $nombre_solicitante, $justificativo, $autorizado_por, $gerente_area, $existencia_activo, $estado_solicitud_activo, $id_usuario);
} else {
	$result = $solicitud_activo->registrar_solicitud_activo_no($nro_solicitud_activo, $fecha_solicitud, $unidad_solicitante, $item_solicitante, $nombre_solicitante, $justificacion, $objetivo_contratacion, $existencia_activo, $estado_solicitud_activo, $id_usuario);
}
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error. nro: ".$nro_solicitud_activo."- Fecha: ".
	$fecha_solicitud."- Programa: ".
	$oficina_solicitante."-".
	$item_solicitante."-".
	$nombre_solicitante."-".
	$justificativo."-".
	$autorizado_por."-".
	$gerente_area."- existe: ".
	$existencia_activo."-".
	$estado_solicitud_activo."-".
	$id_usuario;
}


?>