<?php
include("../../modelo/convocatoria.php");
include("../../modelo/funciones.php");

$id_convocatoria = security($_GET['id']);

$convocatoria = new Convocatoria();

if ($convocatoria->eliminar_convocatoria($id_convocatoria)) {
    echo "Convocatoria eliminada con éxito.";
} else {
    echo "Ocurrió un error al intentar eliminar la convocatoria.";
}
?>
