<?php
	$fecha = date("Y-m-d");
	$id_usuario = $_GET[id_usuario];
    $id_solicitud_activo = $_GET[id];
	include("modelo/asignacion_cargo.php");
	$registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
	$registros_g = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");

	$registro_solicitud = $bd->Consulta("SELECT * from solicitud_activo sm where  id_solicitud_activo=$id_solicitud_activo");
    $registro_sol = $bd->getFila($registro_solicitud);
?>
<h2>EDITAR SOLICITUD activo</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            PLANILLA
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_solicitud_activo" id="frm_solicitud_activo"
            action="control/solicitud_activo_ampe/editar_solicitud_activo_ampe.php" method="post" role="form"
            class="validate form-horizontal form-groups-bordered">
            <input type="hidden" name="id_solicitud_activo" id="id_solicitud_activo"
                class="form-control required text" value='<?php echo $id_solicitud_activo;?>' />
            <div class="form-group">
                <label for="fecha_solicitud" class="col-sm-1 control-label">Fecha solicitud</label>
                <div class="col-sm-2">
                    <input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required"
                        value="<?php echo $registro_sol[fecha_solicitud];?>" disabled />

                </div>
                <label for="programa_solicitud_activo" class="col-sm-1 control-label">Programa</label>
                <div class="col-sm-2">
                    <input type="text" name="programa_solicitud_activo" id="programa_solicitud_activo"
                        class="form-control required" value="<?php echo $registro_sol[programa_solicitud_activo];?>"
                        disabled />
                </div>
                <label for="actividad_solicitud_activo" class="col-sm-1 control-label">Actividad</label>
                <div class="col-sm-2">
                    <input type="text" name="actividad_solicitud_activo" id="actividad_solicitud_activo"
                        class="form-control required" value="<?php echo $registro_sol[actividad_solicitud_activo];?>"
                        disabled />
                </div>
                <label for="existencia_activo" class="col-sm-1 control-label">activo con existencia</label>
                <div class="col-sm-2">
                    <input type="text" name="existencia_activo" id="existencia_activo" class="form-control required"
                        value="<?php echo $registro_sol[existencia_activo];?>" disabled />
                </div>
            </div>
            <div class="form-group">
                <label for="nombre_solicitante" class="col-sm-1 control-label">Nombre solicitante</label>
                <div class="col-sm-3">
                    <input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control required"
                        value="<?php echo utf8_encode($registro_sol[nombre_solicitante]);?>" disabled />
                </div>
                <label for="oficina_solicitante" class="col-sm-1 control-label">Oficina solicitante</label>
                <div class="col-sm-3">
                    <input type="text" name="oficina_solicitante" id="oficina_solicitante" class="form-control required"
                        value="<?php echo $registro_sol[oficina_solicitante];?>" disabled />
                </div>
                <label for="oficina_solicitante" class="col-sm-1 control-label">Visto Bueno</label>
                <div class="col-sm-3">
                    <input type="text" name="visto_bueno" id="visto_bueno" class="form-control required"
                        value="<?php echo $registro_sol[visto_bueno];?>" disabled />
                </div>
            </div>
            <div class="form-group">
                <label for="justificativo" class="col-sm-1 control-label">Justificativo</label>
                <div class="col-sm-3">
                    <textarea name="justificativo" id="justificativo" class="form-control required text uppercase"
                        rows="4"><?php echo $registro_sol[justificativo];?></textarea>
                </div>
                <label for="autorizado_por" class="col-sm-1 control-label">Autorizado por:</label>
                <div class="col-sm-3">
                    <select name="autorizado_por" id="autorizado_por" class="form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
							while($registro = $bd->getFila($registros))
							{
								$nombre = $registro[nombres]." ". $registro[apellido_paterno]." ".$registro[apellido_materno];
								$selected_gerente = $nombre == $registro_sol[gerente_area] ? 'selected' : '';
								echo utf8_encode("<option value='$nombre' $selected_gerente>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>");
							}
						?>

                    </select>
                </div>
                <label for="gerente_area" class="col-sm-1 control-label">Gerente de Área:</label>
                <div class="col-sm-3">
                    <select name="gerente_area" id="gerente_area" class="form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
							while($registro_g = $bd->getFila($registros_g))
							{
								$nombre = $registro_g[nombres]." ". $registro_g[apellido_paterno]." ".$registro_g[apellido_materno];
								$selected_autorizado = $nombre == $registro_sol[autorizado_por] ? 'selected' : '';
								echo utf8_encode("<option value='$nombre' $selected_autorizado>$registro_g[apellido_paterno] $registro_g[apellido_materno] $registro_g[nombres]</option>");
							}
						?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Registrar</button> <button type="reset"
                        class="btn btn-default cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>