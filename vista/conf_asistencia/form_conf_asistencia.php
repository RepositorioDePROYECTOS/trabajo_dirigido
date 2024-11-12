<h2>Crear Asistencia</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Asistencia
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_asistencias" id="frm_conf_asistencias" action="control/conf_asistencia/insertar_conf_asistencias.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre_asistencia" class="col-sm-2 control-label">Nombre asistencia</label>
				<div class="col-sm-9">
					<input type="text" name="nombre_asistencia" id="nombre_asistencia" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="entrada_mañana" class="col-sm-2 control-label">Entrada Mañana</label>
				<div class="col-sm-4">
					<input type="time" name="entrada_mañana" id="entrada_mañana" class="form-control"/>
				</div>
				<label for="salida_mañana" class="col-sm-1 control-label">Salida Mañana</label>
				<div class="col-sm-4">
					<input type="time" name="salida_mañana" id="salida_mañana" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="entrada_tarde" class="col-sm-2 control-label">Entrada Tarde</label>
				<div class="col-sm-4">
					<input type="time" name="entrada_tarde" id="entrada_tarde" class="form-control"/>
				</div>
				<label for="salida_tarde" class="col-sm-1 control-label">Salida Tarde</label>
				<div class="col-sm-4">
					<input type="time" name="salida_tarde" id="salida_tarde" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-2 control-label">Estado aporte</label>
				<div class="col-sm-9">
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
