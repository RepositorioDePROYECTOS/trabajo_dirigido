<?php
include("../../modelo/solicitud_servicio.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_solicitud           = utf8_decode($_POST[fecha_solicitud]);
$oficina_solicitante       = utf8_decode($_POST[oficina_solicitante]);
$item_solicitante          = utf8_decode($_POST[item_solicitante]);
$nombre_solicitante        = utf8_decode($_POST[nombre_solicitante]);
$justificativo             = utf8_decode($_POST[justificativo]);
$objetivo_contratacion     = utf8_decode($_POST[objetivo_contratacion]);
$autorizado_por            = utf8_decode($_POST[autorizado_por]);
$gerente_area              = utf8_decode($_POST[gerente_area]);
$estado_solicitud_servicio = 'SOLICITADO';
// $tipo_solcitud             = utf8_decode($_POST[tipo_solicitud]);
$id_usuario                = utf8_decode($_POST[id_usuario]);

$solicitud_servicio = new solicitud_servicio();
$bd = new conexion();
$registros = $bd->Consulta("SELECT max(nro_solicitud_servicio) as nro_solicitud from solicitud_servicio");
$registro = $bd->getFila($registros);

$nro_solicitud_servicio = $registro[nro_solicitud] + 1;

$result = $solicitud_servicio->registrar_solicitud_servicio($nro_solicitud_servicio,$fecha_solicitud, $oficina_solicitante, $item_solicitante, $nombre_solicitante, $justificativo, $objetivo_contratacion, $autorizado_por, $gerente_area, $estado_solicitud_servicio, $id_usuario);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Error al registrar la Solicitud";
	// echo "Ocuri&oacute; un Error. nro: ". 
	// "INSERT INTO solicitud_servicio (nro_solicitud_servicio, fecha_solicitud, oficina_solicitante, item_solicitante, nombre_solicitante, justificativo, autorizado_por, visto_bueno, gerente_area, estado_solicitud_servicio, id_usuario) 
	//                        values('$nro_solicitud_servicio','$fecha_solicitud', '$oficina_solicitante', '$item_solicitante', '$nombre_solicitante','$justificativo', '$autorizado_por', '$gerente_area',  '$estado_solicitud_servicio', '$id_usuario')";
}


?>