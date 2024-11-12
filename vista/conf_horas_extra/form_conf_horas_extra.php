<h2>Crear Hora Extra</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Hora extra
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_horas_extra" id="frm_conf_horas_extra" action="control/conf_horas_extra/insertar_conf_horas_extra.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="tipo_he" class="col-sm-3 control-label">Tipo hora extra</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_he" id="tipo_he" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="factor_calculo" class="col-sm-3 control-label">Factor de calculo</label>
				<div class="col-sm-5">
					<input type="text" name="factor_calculo" id="factor_calculo" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
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
