<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
	include("../../modelo/derivaciones.php");

	referer_permit();
	setlocale(LC_TIME,"es_ES");
	ini_set('date.timezone','America/La_Paz');

	$fecha_respuesta   = date('Y-m-d H:i:s');

	$id = security($_GET[id]);
	$usuario= security($_GET[id_usuario]);
	$tipo_trabajador = security($_GET[tipo_trabajador]);
	$bd = new conexion();
	if($tipo_trabajador == 'ITEM') {
		$trabajador = $bd->Consulta("SELECT t.id_trabajador 
			FROM trabajador as t 
			INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador 
			WHERE u.id_usuario=$usuario");
	} else {
		$trabajador = $bd->Consulta("SELECT e.id_eventual as id_trabajador 
			FROM eventual as e 
			INNER JOIN usuario as u ON e.id_eventual = u.id_eventual 
			WHERE u.id_usuario=$usuario");
	}
	$t = $bd->getFila($trabajador);
	$id_t = $t[id_trabajador];

	// echo json_encode(array("success" => false, "message" => "ID: ".$id." User: ".$usuario. " Trabajador: ".$id_t));


	$registros = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion=$id");
	$registro = $bd->getFila($registros);
	$derivaciones = new derivaciones();
	$result = $derivaciones->cambiar($id);
	if($result)
	{
		    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($id, $registro[id_solicitud], $id_t, '$registro[tipo_solicitud]', 'solicitado')");
		// echo json_encode(array("success" => false, "message" => "INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($id, $registro[id_solicitud], $registro[id_trabajador], '$registro[tipo_solicitud]', 'devulto')"));
		echo json_encode(array("success" => true));
	}
	else
	{
		// echo json_encode(array("success" => false, "message" => "INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, created_at, estado) VALUES ('$id', $registro[id_solicitud], $registro[id_trabajador], '$registro[tipo_solicitud]', 'devulto')"));
        echo json_encode(array("success" => false, "message" => "Error al derivar"));
	}


?>