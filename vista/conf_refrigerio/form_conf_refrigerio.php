<h2>Crear refrigerio</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Refrigerio
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_refrigerio" id="frm_conf_refrigerio" action="control/conf_refrigerio/insertar_conf_refrigerio.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_refrigerio" class="col-sm-3 control-label">Monto refrigerio</label>
				<div class="col-sm-5">
					<input type="text" name="monto_refrigerio" id="monto_refrigerio" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_refrigerio" class="col-sm-3 control-label">Estado aporte</label>
				<div class="col-sm-5">
					<select name="estado_refrigerio" id="estado_refrigerio" class="form-control required select">
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
