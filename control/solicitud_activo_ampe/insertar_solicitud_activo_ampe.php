<?php
	include("../../modelo/solicitud_activo_ampe.php");
	include("../../modelo/funciones.php");

	referer_permit();

	$fecha_solicitud             = utf8_decode($_POST[fecha_solicitud]);
	$programa_solicitud_activo   = utf8_decode($_POST[programa_solicitud_activo]);
	$actividad_solicitud_activo  = utf8_decode($_POST[actividad_solicitud_activo]);
	$oficina_solicitante         = utf8_decode($_POST[oficina_solicitante]);
	$item_solicitante            = utf8_decode($_POST[item_solicitante]);
	$nombre_solicitante          = utf8_decode($_POST[nombre_solicitante]);
	$justificativo               = utf8_decode(mb_strtoupper($_POST[justificativo]));
	$objetivo_contratacion       = 'ANPE';
	$autorizado_por              = utf8_decode($_POST[autorizado_por]);
	$visto_bueno                 = utf8_decode($_POST[visto_bueno]);
	$gerente_area                = utf8_decode($_POST[gerente_area]);
	$existencia_activo           = utf8_decode($_POST[existencia_activo]);
	$estado_solicitud_activo     = 'SOLICITADO';
	$id_usuario                  = utf8_decode($_POST[id_usuario]);

	$solicitud_activo = new solicitud_activo_ampe();

	$bd = new conexion();

	$registros = $bd->Consulta("select max(nro_solicitud_activo) as nro_solicitud from solicitud_activo");
	$registro = $bd->getFila($registros);

	$nro_solicitud_activo = $registro[nro_solicitud] + 1;
	$result = $solicitud_activo->registrar_solicitud_activo(
			$nro_solicitud_activo,
			$fecha_solicitud, 
			$programa_solicitud_activo, 
			$actividad_solicitud_activo, 
			$oficina_solicitante, 
			$item_solicitante, 
			$nombre_solicitante, 
			$justificativo, 
			$objetivo_contratacion,
			$autorizado_por, 
			$visto_bueno, 
			$gerente_area, 
			$existencia_activo, 
			$estado_solicitud_activo, 
			$id_usuario);
	if($result)
	{
		echo "Datos registrados.";
	}
	else
	{
		echo "Ocuri&oacute; un Error. nro: ".$nro_solicitud_activo."- Fecha: ".
		$fecha_solicitud."- Programa: ".
		$programa_solicitud_activo."- Actividad: ".
		$actividad_solicitud_activo."- Oficina".
		$oficina_solicitante."-".
		$item_solicitante."-".
		$nombre_solicitante."-".
		$justificativo."-".
		$autorizado_por."-".
		$visto_bueno."-".
		$gerente_area."- existe: ".
		$existencia_activo."-".
		$estado_solicitud_activo."-".
		$id_usuario;
	}
