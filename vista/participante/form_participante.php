<h2>Registrar Participante</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			Participante
		</div>
	</div>
	<div class="panel-body">
		<form name="from_postulante" id="from_postulante" action="control/participante/insertar_participante.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">

			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text" placeholder='' />
				</div>
			</div>
			<div class="form-group">
				<label for="ci" class="col-sm-3 control-label">CI</label>
				<div class="col-sm-5">
					<input type="text" name="ci" id="ci" class="form-control required text" placeholder='' />
				</div>
			</div>
			<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefono</label>
				<div class="col-sm-5">
					<input type="text" name="telefono" id="telefono" class="form-control required text" placeholder='' />
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text" placeholder='' />
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