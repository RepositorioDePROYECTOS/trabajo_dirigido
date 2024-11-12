<?php
	include("modelo/asignacion_cargo.php");
	$gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];

    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO' and id_asignacion_cargo not in(select id_asignacion_cargo from bono_antiguedad where mes=$mes and gestion=$gestion)");
?>
<h2>Crear Asistencia</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Asistencia
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_asistencia" id="frm_asistencia" action="control/asistencia/insertar_asistencia.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required enteros" value="<?php echo $mes;?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="id_asignacion_cargo" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<select name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								echo "<option value='$registro[id_asignacion_cargo]'>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>";
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_laborables" class="col-sm-3 control-label">D&iacute;as Laborables</label>
				<div class="col-sm-5">
					<input type="text" name="dias_laborables" id="dias_laborables" class="form-control required enteros" value="30" />
				</div>
			</div>
			<div class="form-group">
				<label for="dias_asistencia" class="col-sm-3 control-label">D&iacute;as Asistencia</label>
				<div class="col-sm-5">
					<input type="text" name="dias_asistencia" id="dias_asistencia" class="form-control required enteros" value="30" />
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
