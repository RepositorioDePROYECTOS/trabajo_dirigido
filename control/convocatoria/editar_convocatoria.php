<?php
include("../../modelo/convocatoria.php");

$id_convocatoria = intval($_POST['id_convocatoria']);
$nombre_convocatoria = $_POST['nombre_convocatoria'];
$Fecha_inicio = $_POST['Fecha_inicio'];
$Fecha_fin = $_POST['Fecha_fin'];
$Estado = intval($_POST['Estado']);
$Vacantes = intval($_POST['Vacantes']);
$Requisitos = $_POST['Requisitos'];

$convocatoria = new convocatoria();

$result = $convocatoria->modificar_convocatoria($id_convocatoria, $nombre_convocatoria, $Fecha_inicio, $Fecha_fin, $Estado, $Vacantes, $Requisitos);

if ($result) {
    echo "Convocatoria actualizada exitosamente.";
} else {
    echo "Ocurrió un error al actualizar la convocatoria.";
}
?>
