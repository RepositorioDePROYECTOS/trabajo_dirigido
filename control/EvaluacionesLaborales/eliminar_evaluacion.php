<?php
include("../../modelo/evaluaciones_laborales.php");

// Obtener el ID de la evaluación a eliminar
$id_evaluacion = intval($_POST['id_evaluacion']);

// Crear instancia de la clase EvaluacionesLaborales
$evaluaciones = new EvaluacionesLaborales();

// Llamar a la función para eliminar la evaluación laboral
$result = $evaluaciones->eliminar_evaluacion($id_evaluacion);

// Verificar el resultado de la eliminación
if ($result) {
    echo "Evaluación laboral eliminada correctamente.";
} else {
    echo "Ocurrió un error al eliminar la evaluación laboral.";
}
?>
