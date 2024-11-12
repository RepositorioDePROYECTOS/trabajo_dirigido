<h2>Crear Vacacion</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Vacacion
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_vacacion" id="frm_conf_vacacion" action="control/conf_vacacion/insertar_conf_vacacion.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="anio_inicio" class="col-sm-3 control-label">A&ntilde;o inicio</label>
				<div class="col-sm-5">
					<input type="text" name="anio_inicio" id="anio_inicio" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="anio_fin" class="col-sm-3 control-label">A&ntilde;o fin</label>
				<div class="col-sm-5">
					<input type="text" name="anio_fin" id="anio_fin" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_vacacion" class="col-sm-3 control-label">D&iacute;as Vacaci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="dias_vacacion" id="dias_vacacion" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_vaca" class="col-sm-3 control-label">Estado Vacaci&oacute;n</label>
				<div class="col-sm-5">
					<select name="estado_vaca" id="estado_vaca" class="form-control required select">
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
