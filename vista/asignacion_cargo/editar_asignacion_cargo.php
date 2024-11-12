
<?php

	include("modelo/asignacion_cargo.php");
    
    $id = security($_GET[id]);

    $asignacion_cargo = new asignacion_cargo();

    $asignacion_cargo->get_asignacion_cargo($id);
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador where ac.id_asignacion_cargo=$id");
    $registro = $bd->getFila($registros);

?>

<h2>Editar Asignaci&oacute;n cargo</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Asignacion cargo
		</div>
</div>
<div class="panel-body">
<form name="frm_asignacion_cargo" id="frm_asignacion_cargo" action="control/asignacion_cargo/editar_asignacion_cargo.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required text" value='<?php echo $asignacion_cargo->id_asignacion_cargo; ?>'/>
			<input type="hidden" name="id_trabajador" id="id_trabajador" class="form-control required text" value='<?php echo $asignacion_cargo->id_trabajador; ?>'/>
			<input type="hidden" name="id_cargo" id="id_cargo" class="form-control required text" value='<?php echo $asignacion_cargo->id_cargo; ?>'/>
	<div class="form-group">
		<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
		<div class="col-sm-5">
			<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno]). " ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="cargo" class="col-sm-3 control-label">Cargo</label>
		<div class="col-sm-5">
			<input type="text" name="cargo" id="cargo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($asignacion_cargo->cargo); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="item" class="col-sm-3 control-label">Item</label>
		<div class="col-sm-5">
			<input type="text" name="item" id="item" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($asignacion_cargo->item); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="fecha_ingreso" class="col-sm-3 control-label">Fecha ingreso</label>
		<div class="col-sm-5">
			<input type="text" name="fecha_ingreso" id="fecha_ingreso" class="form-control required datepicker"  placeholder='' value='<?php echo utf8_encode($asignacion_cargo->fecha_ingreso); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="fecha_salida" class="col-sm-3 control-label">Fecha salida</label>
		<div class="col-sm-5">
			<input type="text" name="fecha_salida" id="fecha_salida" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($asignacion_cargo->fecha_salida); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="salario" class="col-sm-3 control-label">Salario</label>
		<div class="col-sm-5">
			<input type="text" name="salario" id="salario" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($asignacion_cargo->salario); ?>' readonly/>
		</div>
	</div>
	<div class="form-group">
		<label for="aportante_afp" class="col-sm-3 control-label">Aportante AFP</label>
		<div class="col-sm-5">
			<select name="aportante_afp" id="aportante_afp" class="form-control required select">
						<?php
						if($asignacion_cargo->aportante_afp == 0)
						{
							echo "<option value='0' selected>NO</option><option value='1'>SI</option>";
						}
						else
						{
							echo "<option value='1' selected>SI</option><option value='0'>NO</option>";
						}
						?>
						
					</select>
		</div>
	</div>
	<div class="form-group">
		<label for="sindicato" class="col-sm-3 control-label">Sindicalizado</label>
		<div class="col-sm-5">
			<select name="sindicato" id="sindicato" class="form-control required select">
						<?php
						if($asignacion_cargo->sindicato == 0)
						{
							echo "<option value='0' selected>NO</option><option value='1'>SI</option>";
						}
						else
						{
							echo "<option value='1' selected>SI</option><option value='0'>NO</option>";
						}
						?>
						
					</select>
		</div>
	</div>
	<div class="form-group">
		<label for="socio_fe" class="col-sm-3 control-label">Socio fondo empleados</label>
		<div class="col-sm-5">
			<select name="socio_fe" id="socio_fe" class="form-control required select">
						<?php
						if($asignacion_cargo->socio_fe == 0)
						{
							echo "<option value='0' selected>NO</option><option value='1'>SI</option>";
						}
						else
						{
							echo "<option value='1' selected>SI</option><option value='0'>NO</option>";
						}
						?>
						
					</select>
		</div>
	</div>
	<div class="form-group">
		<label for="estado_asignacion" class="col-sm-3 control-label">Estado asignacion</label>
		<div class="col-sm-5">
			<select name="estado_asignacion" id="estado_asignacion" class="form-control required select">
						<?php
						if($asignacion_cargo->estado_asignacion == 'HABILITADO')
						{
							echo "<option value='HABILITADO' selected> HABILITADO</option><option value='INHABILITADO'> INHABILITADO</option>";
						}
						else
						{
							echo "<option value='HABILITADO'> HABILITADO</option><option value='INHABILITADO' selected> INHABILITADO</option>";
						}
						?>
						
					</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
			<button type="submit" class="btn btn-info">Guardar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
		</div>
	</div>
</form>
</div>
</div>
