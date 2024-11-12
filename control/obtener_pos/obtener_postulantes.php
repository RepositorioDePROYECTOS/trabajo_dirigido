<?php
include("../../modelo/conv_lista.php");

$id_convocatoria = intval($_GET['id_convocatoria']);

$convocatoria = new Convocatoria();
$postulantes = $convocatoria->get_postulantes_asignados($id_convocatoria);

echo json_encode($postulantes);
?>
