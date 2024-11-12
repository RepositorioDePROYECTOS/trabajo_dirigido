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
	SETlocale(LC_TIME,"es_ES");
	ini_SET('date.timezone','America/La_Paz');
	$bd = new conexion(); 

	$fecha_accion      = date('Y-m-d H:i:s');
	$estado            = $_POST[estado];
	$id_solicitud      = $_POST[id_solicitud];
    $id_derivacion     = $_POST[id_derivacion];
    $tipo_verificacion = $_POST[tipo_verificacion];

	// echo json_encode(array("success" => false, "message" => $estado." - ID_S:".$id_solicitud." - ID_D: ".$id_derivacion." - TIPO: ".$tipo_verificacion));

	if($estado == "solicitado"){
		// Eliminar la derivacion realizada por el trabajador
		$buscar = $bd->Consulta("DELETE FROM derivaciones WHERE id_derivacion=$id_derivacion");
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='solicitado'");
			echo json_encode(array("success" => true, "message" => "Eliminacion completada con exito!"));
		} else {
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "verificado") {
		// $buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='solicitado' WHERE id_derivacion=$id_derivacion");
		$buscar = $bd->Consulta("DELETE FROM derivaciones WHERE id_derivacion=$id_derivacion");

		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='SOLICITADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='SOLICITADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='SOLICITADO' WHERE id_solicitud_material=$id_solicitud");
		}

		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='verificado'");
			echo json_encode(array("success" => true, "message" => "Se descarto la verificacion de la solicitud!"));
		}
		else {
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "presupuestado"){
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='verificado' WHERE id_derivacion=$id_derivacion");

		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VERIFICADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VERIFICADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VERIFICADO' WHERE id_solicitud_material=$id_solicitud");
		}

		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='presupuestado'");
			echo json_encode(array("success" => true, "message" => "Se elimino lo presupuestado de la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "sin presupuesto"){
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='verificado' WHERE id_derivacion=$id_derivacion");

		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VERIFICADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VERIFICADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VERIFICADO' WHERE id_solicitud_material=$id_solicitud");
		}

		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='sin presupuesto'");
			echo json_encode(array("success" => true, "message" => "Se elimino lo presupuestado de la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "aprobado por RPA"){
		// echo json_encode(array("success" => false, "message" => $estado." - ID_S:".$id_solicitud." - ID_D: ".$id_derivacion." - TIPO: ".$tipo_verificacion));
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='presupuestado' WHERE id_derivacion = $id_derivacion");
		
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='PRESUPUESTADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='PRESUPUESTADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='PRESUPUESTADO' WHERE id_solicitud_material=$id_solicitud");
		}

		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='aprobado por RPA'");
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del RPA a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "rechazado por RPA"){
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='presupuestado' WHERE id_derivacion=$id_derivacion");

		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='PRESUPUESTADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='PRESUPUESTADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='PRESUPUESTADO' WHERE id_solicitud_material=$id_solicitud");
		}

		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='rechazado por RPA'");
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del RPA a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "proveedor asignado") {
		// requisitos con id_solicitud y id derivacion cambia a $estado = 'creado';.
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='aprobado' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='APROBADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='APROBADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='APROBADO' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='proveedor asignado'");
			$eliminar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones = $id_derivacion AND id_solicitud = $id_solicitud");
			while($borrado_requisitos = $bd->getFila($eliminar_requisitos)){
				$delete = $bd->Consulta("DELETE FROM requisitos WHERE id_requisitos=$borrado_requisitos[id_requisitos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del personal de adquisiciones a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "visto_bueno"){
		// Estado de los requisitos = creado
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='proveedor asignado' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='PROVEEDOR ASIGNADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='PROVEEDOR ASIGNADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='PROVEEDOR ASIGNADO' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='visto_bueno'");
			$modificar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones = $id_derivacion AND id_solicitud = $id_solicitud AND estado='creado'");
			while($estado_requisitos = $bd->getFila($modificar_requisitos)){
				$delete = $bd->Consulta("UPDATE requisitos SET estado='creado' WHERE id_requisitos=$estado_requisitos[id_requisitos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del visto bueno a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "sin visto bueno rpa"){
		// Estado de los requisitos = creado
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='proveedor asignado' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='PROVEEDOR ASIGNADO' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='PROVEEDOR ASIGNADO' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='PROVEEDOR ASIGNADO' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='sin visto bueno rpa'");
			$modificar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones = $id_derivacion AND id_solicitud = $id_solicitud AND estado='creado'");
			while($estado_requisitos = $bd->getFila($modificar_requisitos)){
				$delete = $bd->Consulta("UPDATE requisitos SET estado='creado' WHERE id_requisitos=$estado_requisitos[id_requisitos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del visto bueno a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "rechazado por GERENTE ADMINISTRATIVO") {
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VISTO BUENO RPA', observacion='' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VISTO BUENO RPA', observacion='' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VISTO BUENO RPA', observacion='' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='rechazado por GERENTE ADMINISTRATIVO'");
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del visto bueno a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "visto bueno G.A."){
		// Estado de los requisitos = creado
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='visto bueno rpa' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VISTO BUENO RPA' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VISTO BUENO RPA' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VISTO BUENO RPA' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='visto bueno G.A.'");
			$modificar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones = $id_derivacion AND id_solicitud = $id_solicitud AND estado='creado'");
			while($estado_requisitos = $bd->getFila($modificar_requisitos)){
				$delete = $bd->Consulta("UPDATE requisitos SET estado='visto bueno rpa' WHERE id_requisitos=$estado_requisitos[id_requisitos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del visto bueno a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "sin visto bueno G.A."){
		// Estado de los requisitos = creado
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='visto bueno rpa' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VISTO BUENO RPA' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VISTO BUENO RPA' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VISTO BUENO RPA' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='sin visto bueno G.A.'");
			$modificar_requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones = $id_derivacion AND id_solicitud = $id_solicitud AND estado='creado'");
			while($estado_requisitos = $bd->getFila($modificar_requisitos)){
				$delete = $bd->Consulta("UPDATE requisitos SET estado='visto bueno rpa' WHERE id_requisitos=$estado_requisitos[id_requisitos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino la accion del visto bueno a la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	} elseif($estado == "memorandun creado"){
		// Estado de los requisitos = creado
		$buscar = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='visto bueno G.A.' WHERE id_derivacion=$id_derivacion");
		if($tipo_verificacion == "servicio"){
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='VISTO BUENO G.A.' WHERE id_solicitud_servicio=$id_solicitud");
		} elseif($tipo_verificacion == "activo") {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='VISTO BUENO G.A.' WHERE id_solicitud_activo=$id_solicitud");
		} else {
			$cambio_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='VISTO BUENO G.A.' WHERE id_solicitud_material=$id_solicitud");
		}
		if($bd->numFila_afectada() > 0){
			$eliminar = $bd->Consulta("DELETE FROM historicos WHERE id_derivaciones=$id_derivacion AND id_solicitud=$id_solicitud AND tipo_solicitud='$tipo_verificacion' AND estado='memorandun creado'");
			$eliminar_procedimientos = $bd->Consulta("SELECT id_procedimientos FROM procedimientos WHERE id_derivacion = $id_derivacion AND estado='creado'");
			while($borrar_procedimientos = $bd->getFila($eliminar_procedimientos)){
				$delete = $bd->Consulta("DELETE FROM procedimientos WHERE id_procedimientos=$borrar_procedimientos[id_procedimientos]");
			}
			echo json_encode(array("success" => true, "message" => "Se elimino el registro de Memorandun de la solicitud!"));
		}
		else{
			echo json_encode(array("success" => false, "message" => "Problemas al encontrar el registro!"));
		}
	}
?>