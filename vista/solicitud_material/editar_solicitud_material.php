<?php
$fecha = date("Y-m-d");
$id_usuario = $_GET[id_usuario];
$id_solicitud_material = $_GET[id];
include("modelo/asignacion_cargo.php");
$registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
$registros_g = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");

$registro_solicitud = $bd->Consulta("SELECT * from solicitud_material sm where  id_solicitud_material=$id_solicitud_material");
$registro_sol = $bd->getFila($registro_solicitud);
?>
<h2>EDITAR SOLICITUD MATERIAL</h2>
<br />
<div class="panel panel-default panel-shadow" id="" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            PLANILLA
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_solicitud_material" id="frm_solicitud_material" action="control/solicitud_material/editar_solicitud_material.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            <input type="hidden" name="id_solicitud_material" id="id_solicitud_material" class="form-control required text" value='<?php echo $id_solicitud_material; ?>' />
            <div class="form-group">
                <label for="fecha_solicitud" class="col-sm-1 control-label">Fecha solicitud</label>
                <div class="col-sm-3">
                    <input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required" value="<?php echo $registro_sol[fecha_solicitud]; ?>" disabled />

                </div>
                <label for="existencia_material" class="col-sm-2 control-label">Material con existencia</label>
                <div class="col-sm-3">
                    <input type="text" name="existencia_material" id="existencia_material" class="form-control required" value="<?php echo $registro_sol[existencia_material]; ?>" readonly />
                </div>
            </div>
            <div class="si-existe" style="display: none;">
                <div class="form-group">
                    <label for="nombre_solicitante" class="col-sm-1 control-label">Nombre solicitante</label>
                    <div class="col-sm-3">
                        <input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control required" value="<?php echo utf8_encode($registro_sol[nombre_solicitante]); ?>" disabled />
                    </div>
                    <label for="oficina_solicitante" class="col-sm-2 control-label">Oficina solicitante</label>
                    <div class="col-sm-3">
                        <input type="text" name="oficina_solicitante" id="oficina_solicitante" class="form-control required" value="<?php echo $registro_sol[oficina_solicitante]; ?>" disabled />
                    </div>
                </div>
                <div class="form-group">
                    <label for="autorizado_por" class="col-sm-1 control-label">Autorizado por:</label>
                    <div class="col-sm-3">
                        <select name="autorizado_por" id="autorizado_por" class="form-control required select2">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php
                            while ($registro = $bd->getFila($registros)) {
                                $nombre = $registro[nombres] . " " . $registro[apellido_paterno] . " " . $registro[apellido_materno];
                                $selected_autorizado = $nombre == $registro_sol[autorizado_por] ? 'selected' : '';
                                echo utf8_encode("<option value='$nombre' $selected_autorizado>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>");
                            }
                            ?>

                        </select>
                    </div>
                    <label for="gerente_area" class="col-sm-2 control-label">Gerente de Área:</label>
                    <div class="col-sm-3">
                        <select name="gerente_area" id="gerente_area" class="form-control required select2">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php
                            while ($registro_g = $bd->getFila($registros_g)) {
                                $nombre = $registro_g[nombres] . " " . $registro_g[apellido_paterno] . " " . $registro_g[apellido_materno];
                                $selected_gerente = $nombre == $registro_sol[gerente_area] ? 'selected' : '';
                                echo utf8_encode("<option value='$nombre' $selected_gerente>$registro_g[apellido_paterno] $registro_g[apellido_materno] $registro_g[nombres]</option>");
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="justificativo" class="col-sm-1 control-label">Justificativo</label>
                    <div class="col-sm-6">
                        <textarea name="justificativo" id="justificativo" class="form-control required text uppercase" rows="4" size="15"><?php echo utf8_encode($registro_sol[justificativo]); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="no-existe" style="display: none;">
                <div class="form-group">
                    <label for="unidad_solicitante" class="col-sm-3 control-label">Unidad Solicitante</label>
                    <div class="col-sm-6">
                        <input type="text" name="unidad_solicitante" id="unidad_solicitante" class="form-control required text" value="<?php echo $registro_sol[unidad_solicitante]; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="objetivo_contratacion" class="col-sm-3 control-label">Objetivo de Contratación</label>
                    <div class="col-sm-6">
                        <input type="text" name="objetivo_contratacion" id="objetivo_contratacion" class="form-control required text" value="<?php echo $registro_sol[objetivo_contratacion]; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="justificacion" class="col-sm-3 control-label">Justificativo</label>
                    <div class="col-sm-6">
                        <textarea name="justificacion" id="justificacion" class="form-control required text uppercase" rows="4" size="15"><?php echo utf8_encode($registro_sol[justificativo]); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener("load", function() {
        var valor = document.getElementById('existencia_material').value;
        console.log(valor);
        if (valor == 'SI') {
            console.log('Muestra si');
            document.querySelectorAll('.si-existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('.no-existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        } else {
            console.log('Muestra no');
            document.querySelectorAll('.no-existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('.si-existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        }
    });
</script>