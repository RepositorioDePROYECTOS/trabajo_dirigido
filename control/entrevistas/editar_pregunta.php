<?php
include("../../modelo/entrevistas.php");

// Obtener los datos del formulario
$id_entrevista = intval($_POST['id_entrevista']);
$pregunta = $_POST['pregunta'];
$respuesta = $_POST['respuesta'];  // Obtener la nueva respuesta

// Crear instancia de la clase Entrevistas
$entrevista = new Entrevistas();

// Llamar a la función para editar la pregunta y la respuesta
$result = $entrevista->editar_pregunta($id_entrevista, $pregunta, $respuesta);

// Verificar el resultado de la actualización
if ($result) {
    echo "Pregunta editada correctamente.";
} else {
    echo "Ocurrió un error al editar la pregunta.";
}

?>
