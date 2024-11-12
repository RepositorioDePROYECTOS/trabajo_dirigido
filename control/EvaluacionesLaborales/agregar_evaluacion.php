<?php
include("../../modelo/evaluaciones_laborales.php");

// Obtener los datos de la evaluación laboral desde el formulario
$id_convocatoria = intval($_POST['id_convocatoria']);
$id_trabajador = intval($_POST['id_trabajador']);
$pregunta = $_POST['pregunta'];
$observaciones = $_POST['observaciones'];

// Crear instancia de la clase EvaluacionesLaborales
$evaluaciones = new EvaluacionesLaborales();

// Llamar a la función para agregar la evaluación laboral
$result = $evaluaciones->agregar_evaluacion($id_convocatoria, $id_trabajador, $pregunta, $observaciones);

// Verificar el resultado de la inserción
if ($result) {
    echo "Evaluación laboral agregada correctamente.";
} else {
    echo "Ocurrió un error al agregar la evaluación laboral.";
}
?>
