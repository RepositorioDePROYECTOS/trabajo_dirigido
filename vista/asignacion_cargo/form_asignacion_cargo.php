<?php
	include("modelo/trabajador.php");
	$trabajador = new trabajador();
	$registros = $bd->Consulta("select * from trabajador where estado_trabajador='HABILITADO' and id_trabajador not in(select id_trabajador from asignacion_cargo where estado_asignacion='HABILITADO')order by apellido_paterno asc");
	$cargos = $bd->Consulta("select * from cargo where estado_cargo='LIBRE' and id_cargo not in(select id_cargo from asignacion_cargo where estado_asignacion='HABILITADO') order by descripcion asc");
?>
<h2>ASIGNAR CARGO</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Asignaci&oacute;n cargo
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_asignacion_cargo" id="frm_asignacion_cargo" action="control/asignacion_cargo/insertar_asignacion_cargo.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="fecha_ingreso" class="col-sm-3 control-label">Fecha ingreso</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_ingreso" id="fecha_ingreso" class="form-control required datepicker" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_salida" class="col-sm-3 control-label">Fecha salida</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_salida" id="fecha_salida" class="form-control datepicker" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="id_trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<select name="id_trabajador" id="id_trabajador" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								echo "<option value='$registro[id_trabajador]'>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>";
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_cargo" class="col-sm-3 control-label">Cargo</label>
				<div class="col-sm-5">
					<select name="id_cargo" id="id_cargo" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($cargos))
							{
								echo "<option value='$registro[id_cargo]'>$registro[descripcion] ($registro[item])</option>";
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="salario" class="col-sm-3 control-label">Salario</label>
				<div class="col-sm-5" id="salario">
					
				</div>
			</div>
			<div class="form-group">
				<label for="aportante_afp" class="col-sm-3 control-label">Aportante AFP</label>
				<div class="col-sm-5">
					<select name="aportante_afp" id="aportante_afp" class="form-control required select">
						<option value="1" selected>SI</option>
						<option value="0">NO</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="sindicato" class="col-sm-3 control-label">Sindicalizado</label>
				<div class="col-sm-5">
					<select name="sindicato" id="sindicato" class="form-control required select">
						<option value="0" selected>NO</option>
						<option value="1">SI</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="socio_fe" class="col-sm-3 control-label">Socio fondo empleados</label>
				<div class="col-sm-5">
					<select name="socio_fe" id="socio_fe" class="form-control required select">
						<option value="0" selected>NO</option>
						<option value="1">SI</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_asignacion" class="col-sm-3 control-label">Estado asignaci&oacute;n</label>
				<div class="col-sm-5">
					<select name="estado_asignacion" id="estado_asignacion" class="form-control required select">
						<option value="HABILITADO" selected> HABILITADO</option>
						<option value="INHABILITADO">INHABILITADO</option>
					</select>
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
