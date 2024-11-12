<?php
	include("modelo/asignacion_cargo.php");

    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO' and id_asignacion_cargo not in(select id_trabajador from vacacion)");
?>
<h2>Crear vacaci&oacute;n</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Vacaci&oacute;n
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_vacacion" id="frm_vacacion" action="control/vacacion/insertar_vacacion.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<label for="fecha_calculo" class="col-sm-3 control-label">Fecha calculo</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_calculo" id="fecha_calculo" class="form-control required datepicker" readonly />
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
