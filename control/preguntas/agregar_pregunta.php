<?php
include("../../modelo/preguntas.php");

// Obtener los datos del formulario
$id_convocatoria = intval($_POST['id_convocatoria']);
$id_trabajador = intval($_POST['id_trabajador']);
$pregunta = $_POST['pregunta'];
$tipo_respuesta = $_POST['tipo_respuesta'];

// Crear instancia de la clase Preguntas
$preguntas = new Preguntas();


$result = $preguntas->crear_pregunta($id_convocatoria, $id_trabajador, $pregunta,$tipo_respuesta);

// Verificar el resultado de la inserción
if ($result) {
    echo "Pregunta agregada correctamente.";
} else {
    echo "Ocurrió un error al agregar la pregunta.";
}
?>
