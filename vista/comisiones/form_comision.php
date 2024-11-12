<?php
include("modelo/comisiones.php");
?>
<h2>Crear Comisión</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Nueva Comisión
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_comision" id="frm_comision" action="control/comision/insertar_comision.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">

            <!-- Selección de Convocatoria -->
            <div class="form-group">
                <label for="id_convocatoria" class="col-sm-3 control-label">Seleccionar Convocatoria</label>
                <div class="col-sm-5">
                    <select name="id_convocatoria" id="id_convocatoria" class="form-control required select2" data-validate="required" data-message-required="Seleccione una convocatoria" required>
                        <option value="">Seleccione una convocatoria</option>
                        <?php
                        // Consulta para obtener las convocatorias habilitadas y sin comisiones asignadas
                        $convocatorias = $bd->Consulta("SELECT * FROM convocatorias WHERE Estado IN (1, 3) AND id_convocatoria NOT IN (SELECT id_convocatoria FROM comision)");
                        while ($convocatoria = $bd->getFila($convocatorias)) {
                            echo "<option value='{$convocatoria['id_convocatoria']}'>{$convocatoria['nombre_convocatoria']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Selección de Líder (Miembro) -->
            <div class="form-group">
                <label for="lider" class="col-sm-3 control-label">Seleccionar al primer miembro</label>
                <div class="col-sm-5">
                    <select name="id_trabajador" id="lider" class="form-control required select2" data-validate="required" data-message-required="Seleccione un líder" required>
                        <option value="">Seleccione un miembro</option>
                        <?php
                        // Obtener los trabajadores habilitados
                        $trabajadores = $bd->Consulta("SELECT * FROM trabajador WHERE estado_trabajador = 'HABILITADO'");
                        while ($trabajador = $bd->getFila($trabajadores)) {
                            echo "<option value='{$trabajador['id_trabajador']}' style='font-size: 14px;' class='trabajador-option'>{$trabajador['nombres']} {$trabajador['apellido_paterno']} {$trabajador['apellido_materno']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Registrar</button> 
                    <button type="button" class="btn cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
