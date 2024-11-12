<?php
	include("../../modelo/conexion.php");
	include("../../modelo/solicitud_material.php");
	include("../../modelo/funciones.php");

	referer_permit();
	setlocale(LC_TIME,"es_ES");
	ini_set('date.timezone','America/La_Paz');

	$id_solicitud_material = $_GET[id];
	$estado                = $_GET[estado];
	$id_usuario            = $_GET[id_usuario];
	$tipo                  = $_GET[tipo];
	$fecha                 = date("Y-m-d H:i:s");
	$bd = new conexion(); 

	// $array=array("sol: "=>$id_solicitud_material,"estado: "=>$estado,"usuario: "=>$id_usuario,"tipo: "=>$tipo);
	// print_r($array);

	$trabajador = $bd->Consulta("SELECT t.id_trabajador, u.nivel FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
	$t = $bd->getFila($trabajador);
	$id_t = $t[id_trabajador];

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

	$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud_material AND tipo_solicitud='$tipo'");
	$derivacion   = $bd->getFila($derivaciones);

	$requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_derivaciones=$derivacion[id_derivacion] AND id_solicitud = $id_solicitud_material");
	// $r = $bd->getFila($requisitos);
	// print_r($r);
	while($r = $bd->getFila($requisitos)){
		$update_requisitos = $bd->Consulta("UPDATE requisitos SET estado='$estado' WHERE id_requisitos=$r[id_requisitos]");
	}
	$update_derivaciones = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='$estado' WHERE id_derivacion=$derivacion[id_derivacion]");
	$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_material, $id_t, 'material', '$tipo_trabajador', '$estado')");
	$solicitud_material = new solicitud_material();
	if($estado == "visto bueno G.A."){
		$result = $solicitud_material->autorizar_ga($id_solicitud_material);
	}else {
		$result = $solicitud_material->rechazar_ga($id_solicitud_material);
	}


	if($result)
	{
		echo "Aclaro la Solicitud de material.";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}


?>