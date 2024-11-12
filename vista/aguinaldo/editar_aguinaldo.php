
<?php

	include("modelo/aguinaldo.php");
    
    $id = security($_GET[id]);

    $aguinaldo = new aguinaldo();

    $aguinaldo->get_aguinaldo($id);

?>

<h2>Editar Aguinaldo</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Aguinaldo
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_aguinaldo" id="frm_aguinaldo" action="control/aguinaldo/editar_aguinaldo.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_aguinaldo" id="id_aguinaldo" class="form-control required text" value='<?php echo $aguinaldo->id_aguinaldo; ?>'/>
			<div class="form-group">
				<label for="nombre_empleado" class="col-sm-3 control-label">Nombre Empleado</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aguinaldo->nombre_empleado); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="cargo" class="col-sm-3 control-label">Cargo</label>
				<div class="col-sm-5">
					<input type="text" name="cargo" id="cargo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aguinaldo->cargo); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="item" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aguinaldo->item); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="ci" class="col-sm-3 control-label">Ci</label>
				<div class="col-sm-5">
					<input type="text" name="ci" id="ci" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aguinaldo->ci); ?>' readonly/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="sueldo_1" class="col-sm-3 control-label">Total Ganado Septiembre</label>
				<div class="col-sm-5">
					<input type="text" name="sueldo_1" id="sueldo_1" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($aguinaldo->sueldo_1); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="sueldo_2" class="col-sm-3 control-label">Total Ganado Octubre</label>
				<div class="col-sm-5">
					<input type="text" name="sueldo_2" id="sueldo_2" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($aguinaldo->sueldo_2); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="sueldo_3" class="col-sm-3 control-label">Total Ganado Noviembre</label>
				<div class="col-sm-5">
					<input type="text" name="sueldo_3" id="sueldo_3" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($aguinaldo->sueldo_3); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
