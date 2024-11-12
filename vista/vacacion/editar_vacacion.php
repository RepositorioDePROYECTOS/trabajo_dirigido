
<?php

	include("modelo/refrigerio.php");
	include("modelo/trabajador.php");
	include("modelo/asignacion_cargo.php");
    
    $id = security($_GET[id]);

    $refrigerio = new refrigerio();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $refrigerio->get_refrigerio($id);
    $asignacion_cargo->get_asignacion_cargo($refrigerio->id_asignacion_cargo);
    $trabajador->get_trabajador($asignacion_cargo->id_trabajador);
?>

<h2>Editar Vacaci&oacute;n</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Vacaci&oacute;n
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_refrigerio" id="frm_refrigerio" action="control/refrigerio/editar_refrigerio.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_refrigerio" id="id_refrigerio" class="form-control required text" value='<?php echo $refrigerio->id_refrigerio; ?>'/>
					<input type="hidden" name="monto_refrigerio" id="monto_refrigerio" class="form-control required text" value='<?php echo $refrigerio->monto_refrigerio; ?>'/>
			
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ".$trabajador->apellido_materno." ".$trabajador->nombres); ?>'/>
				</div>
			</div>		
			<div class="form-group">
				<label for="dias_laborables" class="col-sm-3 control-label">D&iacute;as laborables</label>
				<div class="col-sm-5">
					<input type="text" name="dias_laborables" id="dias_laborables" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($refrigerio->dias_laborables); ?>' readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="dias_asistencia" class="col-sm-3 control-label">D&iacute;as trabajados</label>
				<div class="col-sm-5">
					<input type="text" name="dias_asistencia" id="dias_asistencia" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($refrigerio->dias_asistencia); ?>'/>
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
