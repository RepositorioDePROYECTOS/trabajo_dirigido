<?php
include("../../modelo/evaluaciones_laborales.php");

// Obtener los datos de la evaluación laboral desde el formulario
$id_evaluacion = intval($_POST['id_evaluacion']);
$pregunta = $_POST['pregunta'];
$observaciones = $_POST['observaciones'];

// Crear instancia de la clase EvaluacionesLaborales
$evaluaciones = new EvaluacionesLaborales();

// Llamar a la función para editar la evaluación laboral
$result = $evaluaciones->editar_evaluacion($id_evaluacion, $pregunta, $observaciones);

// Verificar el resultado de la edición
if ($result) {
    echo "Evaluación laboral actualizada correctamente.";
} else {
    echo "Ocurrió un error al actualizar la evaluación laboral.";
}
?>
