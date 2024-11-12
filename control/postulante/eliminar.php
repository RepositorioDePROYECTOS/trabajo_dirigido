<?php
include("../../modelo/postulante.php");
include("../../modelo/funciones.php");

// Obtener el ID del postulante a eliminar
$id_postulante = security($_GET['id']);

// Crear instancia de la clase Postulante
$postulante = new Postulante();

// Llamar al método para eliminar el postulante
if ($postulante->eliminar_postulante($id_postulante)) {
    echo "Postulante eliminado con éxito.";
} else {
    echo "Ocurrió un error al intentar eliminar el postulante.";
}
?>
