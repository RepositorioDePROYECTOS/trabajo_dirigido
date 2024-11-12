<?php
include("../../modelo/preguntas.php");

// Obtener los datos del formulario
$id_pregunta = intval($_POST['id_pregunta']);
$pregunta = $_POST['pregunta'];

// Crear instancia de la clase Preguntas
$preguntas = new Preguntas();

// Llamar a la función para editar la pregunta
$result = $preguntas->editar_pregunta($id_pregunta, $pregunta);

// Verificar el resultado de la actualización
if ($result) {
    echo "Pregunta editada correctamente.";
} else {
    echo "Ocurrió un error al editar la pregunta.";
}
?>
