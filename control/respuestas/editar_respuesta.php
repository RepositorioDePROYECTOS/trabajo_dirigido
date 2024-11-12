<?php
include("../../modelo/respuestas.php");

$respuestas = new Respuestas();

// Obtener los datos de la solicitud
$id_respuesta = intval($_POST['id_respuesta']);
$tipo_respuesta = $_POST['tipo_respuesta']; // 'abierta', 'multiple' o 'vf' (verdadero/falso)
$respuesta = $_POST['respuesta'];
$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null; // Opcional para tipo múltiple o verdadero/falso

// Editar la respuesta de acuerdo al tipo
if ($tipo_respuesta === 'abierta') {
    $result = $respuestas->editar_respuesta_abierta($id_respuesta, $respuesta);
} else {
    $result = $respuestas->editar_respuesta_cerrada($id_respuesta, $opcion, $respuesta);
}

// Verificar el resultado
if ($result) {
    echo "Respuesta editada correctamente.";
} else {
    echo "Ocurrió un error al editar la respuesta.";
}
?>
