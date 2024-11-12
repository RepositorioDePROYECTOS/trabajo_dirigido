<?php
include("../../modelo/entrevista.php");
include("../../modelo/funciones.php");

referer_permit();

$id_convocatoria = utf8_decode($_POST[id_convocatoria]);
$enunciado_preguntas = utf8_decode($_POST[enunciado_preguntas]);
$calificacion_preguntas = utf8_decode($_POST[calificacion_preguntas]);

$entrevista = new Entrevista();

$result = $entrevista->registrar_preguntas($id_convocatoria, $enunciado_preguntas, $calificacion_preguntas);
if($result)
{
	// echo "Datos registrados.";
	echo json_encode(array("success" => true));
}
else
{
	// echo "Ocuri&oacute; un Error.";
	echo json_encode(array("success" => false,"message" => "Error no se encontraron registros"));
}


?>