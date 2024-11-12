<?php
include("../../modelo/respuestas.php");

$respuestas = new Respuestas();

// Obtener el ID de la pregunta para listar sus respuestas
$id_pregunta = intval($_POST['id_pregunta']);

// Obtener las respuestas
$lista_respuestas = $respuestas->get_respuestas_por_pregunta($id_pregunta);

// Verificar si se obtuvieron resultados
if (!empty($lista_respuestas)) {
    echo json_encode($lista_respuestas); // Retornar las respuestas en formato JSON
} else {
    echo json_encode(["error" => "No se encontraron respuestas para la pregunta especificada."]);
}
?>
