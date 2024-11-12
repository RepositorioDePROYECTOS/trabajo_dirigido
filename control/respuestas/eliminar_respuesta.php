<?php
include("../../modelo/respuestas.php");

$respuestas = new Respuestas();

// Obtener el ID de la respuesta a eliminar
$id_respuesta = intval($_POST['id_respuesta']);

// Eliminar la respuesta
$result = $respuestas->eliminar_respuesta($id_respuesta);

// Verificar el resultado de la eliminación
if ($result) {
    echo "Respuesta eliminada correctamente.";
} else {
    echo "Ocurrió un error al eliminar la respuesta.";
}
?>
