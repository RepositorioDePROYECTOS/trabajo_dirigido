<h2>Crear descuento</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Descuento
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_descuentos" id="frm_conf_descuentos" action="control/conf_descuentos/insertar_conf_descuentos.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre_descuento" class="col-sm-3 control-label">Nombre descuento</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_descuento" id="nombre_descuento" class="form-control required text"/>
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
