<?php
include("../../modelo/comisiones.php");

// Obtener los datos del formulario
$id_convocatoria = $_POST['id_convocatoria'];
$id_trabajador = $_POST['id_trabajador'];

// Crear una nueva instancia de la clase Comision
$comision = new Comision();

// Registrar la nueva comisión con los miembros seleccionados
$result = $comision->registrar_miembro(
    $id_convocatoria, 
    $id_trabajador
);

if ($result) {
    echo "Comisión registrada exitosamente.";
} else {
    echo "Ocurrió un error al registrar la comisión.";
}
?>
