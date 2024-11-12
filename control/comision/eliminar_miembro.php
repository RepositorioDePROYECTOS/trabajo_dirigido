<?php
include("../../modelo/comisiones.php");

// Obtener los datos del formulario
$id_trabajador = intval($_POST['id_trabajador']);
$id_convocatoria = intval($_POST['id_convocatoria']);

// Crear instancia de la clase Comision
$comision = new Comision();

// Llamar a la función de eliminar miembro
$result = $comision->eliminar_miembro($id_trabajador, $id_convocatoria);

// Verificar el resultado de la actualización
if ($result) {
    echo "Miembro eliminado correctamente.";
} else {
    echo "Ocurrió un error al eliminar el miembro.";
}

// Redirigir a la página anterior después de 2 segundos
echo '<script>
        setTimeout(function() {
            window.history.back();
        }, -1000); // Cambia 2000 a la cantidad de milisegundos que desees para la espera
      </script>';
?>
