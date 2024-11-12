<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
	include("../../modelo/derivaciones.php");
	include("../../modelo/solicitud_activo.php");
	include("../../modelo/solicitud_material.php");
	include("../../modelo/solicitud_servicio.php");
	include("../../modelo/detalle_activo.php");
	include("../../modelo/detalle_material.php");
	include("../../modelo/especificacion_activo.php");
	include("../../modelo/especificacion_material.php");
	include("../../modelo/especificacion_servicio.php");

	referer_permit();
	setlocale(LC_TIME,"es_ES");
	ini_set('date.timezone','America/La_Paz');
	$bd = new conexion(); 

	$fecha_accion      = date('Y-m-d H:i:s');
    $id_solicitud      = $_POST[id_solicitud];
    $id_derivacion     = $_POST[id_derivacion];
    $tipo_verificacion = $_POST[tipo_verificacion];

	$informacion   = array();
	$info          = array();
	$info_estado   = array();
	$info_estados  = array();

	$buscar = $bd->Consulta("SELECT h.id_historicos, h.id_derivaciones, h.id_solicitud, h.created_at, h.estado, d.nro_solicitud FROM historicos as h LEFT JOIN derivaciones as d ON d.id_derivacion = h.id_derivaciones WHERE h.id_derivaciones=$id_derivacion AND h.id_solicitud=$id_solicitud AND h.tipo_solicitud='$tipo_verificacion'");

	if($buscar) {
		while($datos = $bd->getFila($buscar)){
			$info = array(
				"id_historicos"     => utf8_encode($datos[id_historicos]),
				"id_derivaciones"   => utf8_encode($datos[id_derivaciones]),
				"id_solicitud"      => utf8_encode($datos[id_solicitud]),
				"nro_solicitud"     => utf8_encode($datos[nro_solicitud]),
				"created_at"        => date("d-m-Y H:i:s", strtotime($datos[created_at])),
				"estado"            => utf8_encode($datos[estado]),
			);
			array_push($informacion, $info);
		}
		$buscar_estados = $bd->Consulta("SELECT h.estado FROM historicos as h INNER JOIN derivaciones as d ON d.id_derivacion = h.id_derivaciones WHERE h.id_derivaciones=$id_derivacion AND h.id_solicitud=$id_solicitud AND h.tipo_solicitud='$tipo_verificacion' ORDER BY h.created_at DESC");

		while($data = $bd->getFila($buscar_estados)){
			array_push($info_estados, utf8_encode($data[estado]));
		}
		echo json_encode(array("success" => true, "message" => "Datos Encontrados", "data" => $informacion, "estados" => $info_estados));
	} else {
		$informacion = array();
		echo json_encode(array("success" => false, "message" => "Datos no Encontrados", "data" => $informacion));
	}



?>