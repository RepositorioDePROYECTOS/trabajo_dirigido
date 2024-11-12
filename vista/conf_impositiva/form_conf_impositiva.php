<h2>Crear impositiva</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Impositiva
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_impositiva" id="frm_conf_impositiva" action="control/conf_impositiva/insertar_conf_impositiva.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="salario_minimo" class="col-sm-3 control-label">Salario minimo</label>
				<div class="col-sm-5">
					<input type="text" name="salario_minimo" id="salario_minimo" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="cant_sm" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-5">
					<input type="text" name="cant_sm" id="cant_sm" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje_imp" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje_imp" id="porcentaje_imp" class="form-control required decimales"/>
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
