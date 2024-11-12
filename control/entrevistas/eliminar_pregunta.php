<?php
include("../../modelo/entrevistas.php");

// Obtener el ID de la pregunta a eliminar
$id_entrevista = intval($_POST['id_entrevista']);

// Crear instancia de la clase Entrevistas
$entrevista = new Entrevistas();

// Llamar a la función para eliminar la pregunta
$result = $entrevista->eliminar_pregunta($id_entrevista);

// Verificar el resultado de la eliminación
if ($result) {
    echo "Pregunta eliminada correctamente.";
} else {
    echo "Ocurrió un error al eliminar la pregunta.";
}

?>
