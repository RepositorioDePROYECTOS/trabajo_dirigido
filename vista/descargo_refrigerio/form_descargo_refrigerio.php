<h2>Crear Entidad</h2>
                      <br />
                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                      	<div class="panel-heading">
    				  		<div class="panel-title">
    							Entidad
    				  		</div>
    				  	</div>
	<div class="panel-body">
		<form name="frm_entidad" id="frm_entidad" action="control/entidad/insertar_entidad.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre_entidad" class="col-sm-3 control-label">Nombre entidad</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_entidad" id="nombre_entidad" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="ubicacion" class="col-sm-3 control-label">Ubicacion</label>
				<div class="col-sm-5">
					<input type="text" name="ubicacion" id="ubicacion" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direccion</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="telefonos" class="col-sm-3 control-label">Telefonos</label>
				<div class="col-sm-5">
					<input type="text" name="telefonos" id="telefonos" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text"/>
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
