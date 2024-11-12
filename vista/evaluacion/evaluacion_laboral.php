<?php
include("modelo/evaluaciones_laborales.php");

$bd = new Conexion();
$id_convocatoria = $_GET['id_convocatoria'];
$id_trabajador = $_GET['id_trabajador'];

// Obtener datos de la convocatoria
$consulta_convocatoria = $bd->Consulta("SELECT nombre_convocatoria FROM convocatorias WHERE id_convocatoria = $id_convocatoria");
$convocatoria = $bd->getFila($consulta_convocatoria);

// Obtener datos del trabajador
$consulta_trabajador = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = $id_trabajador");
$trabajador = $bd->getFila($consulta_trabajador);

// Obtener preguntas y observaciones de evaluaciones laborales
$consulta_evaluaciones = $bd->Consulta("SELECT pregunta, observaciones FROM evaluaciones_laborales WHERE id_convocatoria = $id_convocatoria AND id_trabajador = $id_trabajador");
?>

<!-- Mostrar detalles de la convocatoria y el trabajador -->
<h2>Evaluación Laboral</h2>

<a href="?mod=evaluacion&pag=form_evaluacion&id_convocatoria=<?php echo $id_convocatoria; ?>&id_trabajador=<?php echo $id_trabajador; ?>" 
   class="btn btn-green btn-icon" style="float: right;">
    Agregar evaluación
    <i class="entypo-plus"></i>
</a>

<p><strong>Convocatoria:</strong> <?php echo $convocatoria['nombre_convocatoria']; ?></p>
<p><strong>Trabajador:</strong> <?php echo $trabajador['nombres'] . " " . $trabajador['apellido_paterno'] . " " . $trabajador['apellido_materno']; ?></p>

<!-- Tabla para mostrar preguntas y observaciones -->
<table class="table table-bordered datatable" id="table-evaluaciones">
    <thead>
        <tr>
            <th>No</th>
            <th>Pregunta</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        while ($evaluacion = $bd->getFila($consulta_evaluaciones)) {
            $n++;
            echo "<tr>";
            echo "<td>$n</td>";
            echo "<td>" . utf8_encode($evaluacion['pregunta']) . "</td>";
            echo "<td>" . utf8_encode($evaluacion['observaciones']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- Botón para regresar a la página anterior -->
<button onclick="history.back()" class="btn btn-danger btn-icon" style="float: right;">
    Volver <i class="entypo-back"></i>
</button>
