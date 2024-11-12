<?php
include("../../modelo/preguntas.php");

// Obtener el ID de la pregunta a eliminar
$id_pregunta = intval($_POST['id_pregunta']);

// Crear instancia de la clase Preguntas
$preguntas = new Preguntas();

// Llamar a la función para eliminar la pregunta
$result = $preguntas->eliminar_pregunta($id_pregunta);

// Verificar el resultado de la eliminación
if ($result) {
    echo "Pregunta eliminada correctamente.";
} else {
    echo "Ocurrió un error al eliminar la pregunta.";
}
?>
