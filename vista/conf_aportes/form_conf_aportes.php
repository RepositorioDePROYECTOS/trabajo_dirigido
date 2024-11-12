<h2>Crear Aporte</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Aporte
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_aportes" id="frm_conf_aportes" action="control/conf_aportes/insertar_conf_aportes.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="tipo_aporte" class="col-sm-3 control-label">Tipo Aporte</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_aporte" id="tipo_aporte" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="rango_inicial" class="col-sm-3 control-label">Rango inicial</label>
				<div class="col-sm-5">
					<input type="text" name="rango_inicial" id="rango_inicial" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="rango_final" class="col-sm-3 control-label">Rango final</label>
				<div class="col-sm-5">
					<input type="text" name="rango_final" id="rango_final" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="porc_aporte" class="col-sm-3 control-label">Porcentaje Aporte</label>
				<div class="col-sm-5">
					<input type="text" name="porc_aporte" id="porc_aporte" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado aporte</label>
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
