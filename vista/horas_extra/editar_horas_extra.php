
<?php

	include("modelo/horas_extra.php");
	include("modelo/asignacion_cargo.php");
	include("modelo/trabajador.php");
    
    $id = security($_GET[id]);

    $horas_extra = new horas_extra();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $horas_extra->get_horas_extra($id);
    $asignacion_cargo->get_asignacion_cargo($horas_extra->id_asignacion_cargo);
    $trabajador->get_trabajador($asignacion_cargo->id_trabajador);

?>

<h2>Editar hora extra</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Hora extra
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_horas_extra" id="frm_horas_extra" action="control/horas_extra/editar_horas_extra.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_horas_extra" id="id_horas_extra" class="form-control required text" value='<?php echo $horas_extra->id_horas_extra; ?>'/>
					<input type="hidden" name="factor_calculo" id="factor_calculo" class="form-control required text" value='<?php echo $horas_extra->factor_calculo; ?>'/>
					<input type="hidden" name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required text" value='<?php echo $horas_extra->id_asignacion_cargo; ?>'/>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($horas_extra->gestion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($horas_extra->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="id_asignacion_cargo" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ". $trabajador->apellido_materno." ".$trabajador->nombres); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="tipo_he" class="col-sm-3 control-label">Tipo de hora extra</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_he" id="tipo_he" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($horas_extra->tipo_he); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-5">
					<input type="text" name="cantidad" id="cantidad" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($horas_extra->cantidad); ?>'/>
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
