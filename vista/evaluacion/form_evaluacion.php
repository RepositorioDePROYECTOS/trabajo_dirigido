<?php
include("modelo/evaluaciones_laborales.php");

$bd = new Conexion(); // Asegurarse de que la conexión esté disponible

// Obtener los IDs desde la URL
$id_convocatoria = intval($_GET['id_convocatoria']);
$id_trabajador = intval($_GET['id_trabajador']);

// Consultas para obtener el nombre de la convocatoria y el trabajador
$convocatoria = $bd->getFila($bd->Consulta("SELECT nombre_convocatoria FROM convocatorias WHERE id_convocatoria = $id_convocatoria"));
$trabajador = $bd->getFila($bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = $id_trabajador"));

?>

<h2>Evaluación Laboral</h2>
<br />

<!-- Información de la convocatoria y el trabajador -->
<div>
    <h3>Convocatoria: <?php echo $convocatoria['nombre_convocatoria']; ?></h3>
    <h3>Trabajador: <?php echo $trabajador['nombres'] . ' ' . $trabajador['apellido_paterno'] . ' ' . $trabajador['apellido_materno']; ?></h3>
</div>
<br />

<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Nueva Pregunta de Evaluación Laboral
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_evaluacion" id="frm_evaluacion" action="control/EvaluacionesLaborales/agregar_evaluacion.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            
            <!-- Campo Oculto para IDs -->
            <input type="hidden" name="id_convocatoria" value="<?php echo $id_convocatoria; ?>">
            <input type="hidden" name="id_trabajador" value="<?php echo $id_trabajador; ?>">

            <!-- Pregunta -->
            <div class="form-group">
                <label for="pregunta" class="col-sm-3 control-label">Pregunta</label>
                <div class="col-sm-5">
                    <textarea name="pregunta" id="pregunta" class="form-control required text" data-validate="required" data-message-required="Escriba la pregunta" placeholder=""></textarea>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Agregar Pregunta</button>
                    <button type="button" class="btn cancelar" onclick="history.back();">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
