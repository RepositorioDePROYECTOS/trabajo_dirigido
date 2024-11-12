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
	$bd = new conexion();

	$registros = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion=$id");
	$registro = $bd->getFila($registros);
	$derivaciones = new derivaciones();
	$result = $derivaciones->devolver($id);
	if($result)
	{
		    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($id, $registro[id_solicitud], $registro[id_trabajador], '$registro[tipo_solicitud]', 'devulto')");
		// echo json_encode(array("success" => false, "message" => "INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($id, $registro[id_solicitud], $registro[id_trabajador], '$registro[tipo_solicitud]', 'devulto')"));
		echo "Devuelto";
	}
	else
	{
		// echo json_encode(array("success" => false, "message" => "INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ('$id', $registro[id_solicitud], $registro[id_trabajador], '$registro[tipo_solicitud]', 'devulto')"));
		echo "Error al devolver";
	}


?>