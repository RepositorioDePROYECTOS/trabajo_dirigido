<?php
include("../../modelo/entrevistas.php");

// Obtener los datos del formulario
$id_convocatoria = intval($_POST['id_convocatoria']);
$id_trabajador = intval($_POST['id_trabajador']);
$pregunta = $_POST['pregunta'];
$respuesta = $_POST['respuesta'];  // Obtener la respuesta

// Crear instancia de la clase Entrevistas
$entrevista = new Entrevistas();

// Llamar a la función para agregar la pregunta y la respuesta
$result = $entrevista->agregar_pregunta($id_convocatoria, $id_trabajador, $pregunta, $respuesta);

// Verificar el resultado de la inserción
if ($result) {
    echo "Pregunta agregada correctamente.";
} else {
    echo "Ocurrió un error al agregar la pregunta.";
}

?>
