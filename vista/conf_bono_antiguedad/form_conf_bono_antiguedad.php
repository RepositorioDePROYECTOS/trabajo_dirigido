<h2>Crear Bono</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Bono
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_conf_bono_antiguedad" id="frm_conf_bono_antiguedad" action="control/conf_bono_antiguedad/insertar_conf_bono_antiguedad.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="anio_i" class="col-sm-3 control-label">A&ntilde;o inicio</label>
				<div class="col-sm-5">
					<input type="text" name="anio_i" id="anio_i" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="anio_f" class="col-sm-3 control-label">A&ntilde;o fin</label>
				<div class="col-sm-5">
					<input type="text" name="anio_f" id="anio_f" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje" id="porcentaje" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_bono" class="col-sm-3 control-label">Estado bono</label>
				<div class="col-sm-5">
					<select name="estado_bono" id="estado_bono" class="form-control required select">
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
