<?php
	include("../../modelo/solicitud_activo.php");
	include("../../modelo/funciones.php");

	referer_permit();
	setlocale(LC_TIME, "es_ES");
	ini_set('date.timezone', 'America/La_Paz');

	$id_solicitud_activo = $_GET[id];
	$estado                = $_GET[estado];
	$id_usuario            = $_GET[id_usuario];
	$tipo                  = $_GET[tipo];
	$fecha                 = date("Y-m-d H:i:s");
	$bd = new conexion();

	$trabajador = $bd->Consulta("SELECT t.id_trabajador, u.nivel FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
	$t = $bd->getFila($trabajador);
	$id_t = $t[id_trabajador];

	$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud_activo AND tipo_solicitud='$tipo'");
	$derivacion   = $bd->getFila($derivaciones);

	$requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones=$derivacion[id_derivacion] AND id_solicitud = $id_solicitud_activo");

	// Verificacion
	$tipo_trabajador = "";
	$verificacion_usuario = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador WHERE u.id_usuario=$id_usuario");
	$verificacion_usuarios = $bd->getFila($verificacion_usuario);
	if($verificacion_usuarios[id_trabajador]){
		$tipo_trabajador = "ITEM";
	} else {
		// $usuario = $bd->Consulta("SELECT t.id_eventual as id_trabajador FROM eventual as t INNER JOIN usuario as u ON u.id_eventual = t.id_eventual WHERE u.id_usuario=$id_usuario");
		// $user = $bd->getFila($usuario);
		$tipo_trabajador = "EVENTUAL";
	}

	while ($r = $bd->getFila($requisitos)) {
		$update_requisitos = $bd->Consulta("UPDATE requisitos SET estado='$estado' WHERE id_requisitos=$r[id_requisitos]");
	}
	$update_derivaciones = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='$estado' WHERE id_derivacion=$derivacion[id_derivacion]");
	$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_activo, $id_t, 'activo', '$tipo_trabajador', '$estado')");

	if ($tipo == "material") {
		$detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT SUM(d.precio_total) as total_gastado
					FROM solicitud_material as s 
					INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_material
					INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
					INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
					INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
					WHERE s.id_solicitud_material=$derivacion[id_solicitud]
					GROUP BY p.id_proveedor");
		$requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_material as id_detalle, r.id_requisitos 
					FROM detalle_material as d
					INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
					WHERE id_solicitud_material=$derivacion[id_solicitud]
					AND  r.id_proveedor=$derivacion[id_derivacion]");
	} elseif ($tipo == 'activo') {
		$detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT SUM(d.precio_total) as total_gastado
					FROM solicitud_activo as s 
					INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_activo
					INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo
					INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
					INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
					where s.id_solicitud_activo= $derivacion[id_solicitud]
					GROUP BY p.id_proveedor");
		$requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_activo as id_detalle, r.id_requisitos 
					FROM detalle_activo as d
					INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo 
					where id_solicitud_activo= $derivacion[id_solicitud]
					AND  r.id_proveedor=$derivacion[id_derivacion]");
	} else {
		$detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT SUM(d.precio_total) as total_gastado
				FROM solicitud_servicio as s 
				INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_servicio
				INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio
				INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
				INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
				where s.id_solicitud_servicio = $derivacion[id_solicitud]
				GROUP BY p.id_proveedor");
		$requisitos_detallados = $bd->Consulta("SELECT d.id_detalle_servicio as id_detalle, r.id_requisitos 
				FROM detalle_servicio as d
				INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
				where id_solicitud_servicio = $derivacion[id_solicitud]
				AND  r.id_proveedor=$derivacion[id_derivacion]");
	}


	$solicitud_activo = new solicitud_activo();
	if ($estado == "visto bueno G.A.") {
		$result = $solicitud_activo->autorizar_ga($id_solicitud_activo);
		
		$monto_gastado_elapas = $bd->getFila($detalles_de_solicitud_por_requisito);
		// if( intval($monto_gastado_elapas[total_gastado]) <= 20000 ){
		// 	while ($requisitos = $bd->getFila($requisitos_detallados)) {
		// 		array_push(
		// 			$array,
		// 			array(
		// 				"responsable" => $responsable,
		// 				"id_detalle"  => $requisitos['id_detalle'],
		// 				"id_requistos" => $requisitos['id_requisitos'],
		// 				"tipo"        => $val_tipo,
		// 			)
		// 		);
		// 	}
		// 	$update_derivacion = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='memorandun' WHERE id_derivacion=$val_id_derivacion");
		// 	foreach ($array as $key) {
		// 		$key[responsable];
		// 		$insertar = $bd->Consulta("INSERT INTO procedimientos (id_derivacion, id_requisitos, id_detalles, id_proveedor, fecha_elaboracion, responsable, designado, cuce, created_at, tipo, estado) VALUES ($val_id_derivacion, $key[id_requistos], $key[id_detalle], $val_id_proveedor, '$fecha', $rpa, $key[responsable], '$cuce', '$fecha_respuesta', '$val_tipo', 'creado')");
		// 	}
		// } else {

		}
	else {
		$result = $solicitud_activo->rechazar_ga($id_solicitud_activo);
	}
	if ($result) {
		echo "Solicitud de activo Aprobado.";
	} else {
		echo "Ocuri&oacute; un Error.";
	}
