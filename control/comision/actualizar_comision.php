<?php
include("../../modelo/comisiones.php");

// Obtener los datos del formulario
$id_convocatoria = intval($_POST['id_convocatoria']);
$id_trabajador = intval($_POST['id_trabajador']);

// Crear instancia de la clase Comision
$comision = new Comision();

// Llamar a la función de modificar comisión
$result = $comision->registrar_miembro($id_convocatoria,  $id_trabajador);

// Verificar el resultado de la actualización
if($result) {
    echo "Miembro insertado correctamente.";
} else {
    echo "Ocurrió un error al actualizar la comisión.";
}

// Redirigir a la página anterior después de 2 segundos
echo '<script>
        setTimeout(function() {
            window.history.back();
        }, -1000); // Cambia 2000 a la cantidad de milisegundos que desees para la espera
      </script>';
?>
