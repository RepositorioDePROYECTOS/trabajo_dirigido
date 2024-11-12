<?php

session_start();

include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/requisitos.php");

referer_permit();

$requisitos = new requisitos();
$bd = new conexion();

$id_solicitud = security($_GET[id_solicitud]);
$id_detalle   = security($_GET[id_detalle]);

$busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos WHERE id_solicitud=$id_solicitud AND id_detalle=$id_detalle");
$datos = $bd->getFila($busqueda_requisitos);
// echo json_encode(array("success" => false, "id"=> $datos[id_requisitos], "message" => 'Sin Registros '.$id));
// echo json_encode(array("success" => false, "message" => "SELECT * FROM requisitos WHERE id_solicitud=$id_solicitud AND id_detalle=$id_detalle", "id" => $datos[id_requisitos]));
$result = $requisitos->eliminar($datos[id_requisitos]);
if($bd->numFila_afectada() > 0)
{
	echo json_encode(array("success" => true, "message" => "Acci&oacute;n completada con &eacute;xito"));
}
else
{
	echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error."));
}


?>