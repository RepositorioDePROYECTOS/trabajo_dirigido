<?php
include("../../modelo/convocatoria.php");

$nombre_convocatoria = $_POST['nombre_convocatoria'];
$Fecha_inicio = $_POST['Fecha_inicio'];
$Fecha_fin = $_POST['Fecha_fin'];
$Estado = intval($_POST['Estado']);  
$Vacantes = intval($_POST['Vacantes']); 
$Requisitos = $_POST['Requisitos'];  

$convocatoria = new Convocatoria();

$result = $convocatoria->registrar_convocatoria($nombre_convocatoria, $Fecha_inicio, $Fecha_fin, $Estado, $Vacantes, $Requisitos);

if ($result) {
    echo "Convocatoria registrada exitosamente.";
} else {
    echo "Ocurrió un error al registrar la convocatoria.";
}
?>
