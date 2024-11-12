<h2>CREAR TRABAJADOR</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Trabajador Eventual
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_eventual" id="frm_eventual" action="control/eventual/insertar_eventual.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			
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
				<label for="item" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required entero"/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Nivel</label>
				<div class="col-sm-5">
					<input type="text" name="nivel" id="nivel" class="form-control required entero" />
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Cargo del eventual</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text" />
				</div>
			</div>
			<div class="form-group">
				<label for="seccion" class="col-sm-3 control-label">Seccion</label>
				<div class="col-sm-5">
					<input type="text" name="seccion" id="seccion" class="form-control required text" />
				</div>
			</div>
			<div class="form-group">
				<label for="salario_mensual" class="col-sm-3 control-label">Salario Mensual</label>
				<div class="col-sm-5">
					<input type="text" name="salario_mensual" id="salario_mensual" class="form-control required decimales" />
				</div>
			</div>
			<div class="form-group">
				<label for="estado_eventual" class="col-sm-3 control-label">Estado del eventual</label>
				<div class="col-sm-5">
					<select name="estado_eventual" id="estado_eventual" class="form-control required select">
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
