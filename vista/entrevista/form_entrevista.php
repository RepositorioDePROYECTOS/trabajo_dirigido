<h2>Registrar Entrevista</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			Entrevista
		</div>
	</div>
	<div class="panel-body">
		<form name="from_entrevista" id="from_entrevista" action="control/entrevista/insertar_entrevista.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">

			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Titulo Entrevista</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text" placeholder='' />
				</div>
			</div>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<!-- <input type="text" name="mes" id="mes" class="form-control required text" placeholder='' /> -->
					<select name="mes" id="mes" class="form-control required text">
						<option value="" disabled  selected>...Seleccione...</option>
						<option value="Enero">Enero</option>
						<option value="Febrero">Febrero</option>
						<option value="Marzo">Marzo</option>
						<option value="Abril">Abril</option>
						<option value="Mayo">Mayo</option>
						<option value="Junio">Junio</option>
						<option value="Julio">Julio</option>
						<option value="Agosto">Agosto</option>
						<option value="Septiembre">Septiembre</option>
						<option value="Octubre">Octubre</option>
						<option value="Noviembre">Noviembre</option>
						<option value="Diciembre">Diciembre</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gestion</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text" placeholder='' value="<?php echo date("Y")?>" readonly />
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