<?php
include("../../modelo/postulante.php");

$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$CI = intval($_POST['CI']);
$Gmail = $_POST['Gmail'];
$telefono = intval($_POST['telefono']);
$id_convocatoria = intval($_POST['id_convocatoria']);

$postulante = new Postulante();

$result = $postulante->registrar_postulante($nombre, $apellido_paterno, $apellido_materno, $CI, $Gmail, $telefono, $id_convocatoria);

if ($result) {
    echo "Postulante registrado exitosamente.";
} else {
    echo "Ocurrió un error al registrar el postulante.";
}
?>
