<?php
include("../../modelo/comisiones.php");

// Obtener los datos del formulario
$id_convocatoria = intval($_POST['id_convocatoria']);
$id_trabajador = intval($_POST['id_trabajador']);

// Crear instancia de la clase Comision
$comision = new Comision();

// Llamar a la función de agregar miembro
$result = $comision->agregar_miembro($id_convocatoria, $id_trabajador);

// Verificar el resultado de la actualización
if ($result) {
    echo "Miembro agregado correctamente.";
} else {
    echo "Ocurrió un error al agregar el miembro.";
}
?>
s