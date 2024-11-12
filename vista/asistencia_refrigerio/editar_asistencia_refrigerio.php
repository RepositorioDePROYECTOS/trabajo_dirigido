
<?php

	include("modelo/asistencia_refrigerio.php");
	include("modelo/trabajador.php");
	include("modelo/asignacion_cargo.php");
    
    $id = security($_GET[id]);

    $asistencia_refrigerio = new asistencia_refrigerio();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $asistencia_refrigerio->get_asistencia_refrigerio($id);
    $asignacion_cargo->get_asignacion_cargo($asistencia_refrigerio->id_asignacion_cargo);
    $trabajador->get_trabajador($asignacion_cargo->id_trabajador);



?>

<h2>Editar Asistencia Refrigerio</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Asistencia refrigerio
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_asistencia_refrigerio" id="frm_asistencia" action="control/asistencia_refrigerio/editar_asistencia_refrigerio.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_asistencia_refrigerio" id="id_asistencia_refrigerio" class="form-control required text" value='<?php echo $asistencia_refrigerio->id_asistencia_refrigerio; ?>'/>
			
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ".$trabajador->apellido_materno." ".$trabajador->nombres); ?>'/>
				</div>
			</div>		
			<div class="form-group">
				<label for="dias_laborables" class="col-sm-3 control-label">D&iacute;as laborables</label>
				<div class="col-sm-5">
					<input type="text" name="dias_laborables" id="dias_laborables" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($asistencia_refrigerio->dias_laborables); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_asistencia" class="col-sm-3 control-label">D&iacute;as trabajados</label>
				<div class="col-sm-5">
					<input type="text" name="dias_asistencia" id="dias_asistencia" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($asistencia_refrigerio->dias_asistencia); ?>'/>
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
