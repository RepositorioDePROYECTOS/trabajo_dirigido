<h2>CREAR TRABAJADOR</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Trabajador
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_trabajador" id="frm_trabajador" action="control/trabajador/insertar_trabajador.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="ci" class="col-sm-3 control-label">CI</label>
				<div class="col-sm-5">
					<input type="text" name="ci" id="ci" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="exp" class="col-sm-3 control-label">Expedido</label>
				<div class="col-sm-5">
					<select name="exp" id="exp" class="form-control required select">
						<option value="CHUQUISACA" selected>CHUQUISACA</option>
						<option value="POTOSI">POTOSI</option>
						<option value="ORURO">ORURO</option>
						<option value="LA PAZ">LA PAZ</option>
						<option value="COCHABAMBA">COCHABAMBA</option>
						<option value="TARIJA">TARIJA</option>
						<option value="SANTA CRUZ">SANTA CRUZ</option>
						<option value="BENI">BENI</option>
						<option value="PANDO">PANDO</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nua" class="col-sm-3 control-label">NUA</label>
				<div class="col-sm-5">
					<input type="text" name="nua" id="nua" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-5">
					<input type="text" name="nombres" id="nombres" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellidos" class="col-sm-3 control-label">Apellido Paterno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellidos" class="col-sm-3 control-label">Apellido Materno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_materno" id="apellido_materno" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="sexo" class="col-sm-3 control-label">Sexo</label>
				<div class="col-sm-5">
					<select name="sexo" id="sexo" class="form-control required select">
						<option value="F" selected>FEMENINO</option>
						<option value="M">MASCULINO</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nacionalidad" class="col-sm-3 control-label">Nacionalidad</label>
				<div class="col-sm-5">
					<input type="text" name="nacionalidad" id="nacionalidad" class="form-control required text" value="BOLIVIANA" />
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_nacimiento" class="col-sm-3 control-label">Fecha nacimiento</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control required datepicker" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_anios" class="col-sm-3 control-label">A&ntilde;os antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_anios" id="antiguedad_anios" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_meses" class="col-sm-3 control-label">Meses antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_meses" id="antiguedad_meses" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_dias" class="col-sm-3 control-label">D&iacute;as antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_dias" id="antiguedad_dias" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_trabajador" class="col-sm-3 control-label">Estado trabajador</label>
				<div class="col-sm-5">
					<select name="estado_trabajador" id="estado_trabajador" class="form-control required select">
						<option value="HABILITADO" selected>HABILITADO</option>
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
