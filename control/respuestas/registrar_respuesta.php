<?php
include("../../modelo/respuestas.php");

$respuestas = new Respuestas();

// Obtener los datos de la solicitud
$id_pregunta = intval($_POST['id_pregunta']);
$tipo_respuesta = $_POST['tipo_respuesta']; // 'abierta', 'multiple' o 'vf' (verdadero/falso)
$respuesta = $_POST['respuesta'];
$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null; // Opcional para tipo múltiple o verdadero/falso

// Registrar la respuesta de acuerdo al tipo
if ($tipo_respuesta === 'abierta') {
    $result = $respuestas->registrar_respuesta_abierta($id_pregunta, $respuesta);
} else {
    $result = $respuestas->registrar_respuesta_cerrada($id_pregunta, $opcion, $respuesta);
}

// Verificar el resultado
if ($result) {
    echo "Respuesta registrada correctamente.";
} else {
    echo "Ocurrió un error al registrar la respuesta.";
}
?>
