<?php
include("../../modelo/postulante.php");

$id_postulante = intval($_POST['id_postulante']);
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$CI = intval($_POST['CI']);
$Gmail = $_POST['Gmail'];
$telefono = intval($_POST['telefono']);
$id_convocatoria = intval($_POST['id_convocatoria']);

$postulante = new Postulante();

$result = $postulante->modificar_postulante($id_postulante, $nombre, $apellido_paterno, $apellido_materno, $CI, $Gmail, $telefono, $id_convocatoria);

if ($result) {
    echo "Postulante actualizado exitosamente.";
} else {
    echo "Ocurrió un error al actualizar el postulante.";
}
?>
