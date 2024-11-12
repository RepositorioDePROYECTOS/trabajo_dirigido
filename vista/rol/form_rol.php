<h2>Crear Rol</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Rol
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_rol" id="frm_rol" action="control/rol/insertar_rol.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text" data-validate="required"  data-message-required="Escriba el correo" placeholder='administrador, gerente, etc.'/></td>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
