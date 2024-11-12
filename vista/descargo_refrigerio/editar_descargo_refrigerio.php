
<?php

	include("modelo/descargo_refrigerio.php");
	include("modelo/asistencia_refrigerio.php");
	include("modelo/trabajador.php");
	include("modelo/asignacion_cargo.php");
    
    $id = security($_GET[id]);

    $descargo_refrigerio = new descargo_refrigerio();
    $asistencia_refrigerio = new asistencia_refrigerio();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $descargo_refrigerio->get_descargo_refrigerio($id);
    $asistencia_refrigerio->get_asistencia_refrigerio($descargo_refrigerio->id_asistencia_refrigerio);
    $asignacion_cargo->get_asignacion_cargo($asistencia_refrigerio->id_asignacion_cargo);
    $trabajador->get_trabajador($asignacion_cargo->id_trabajador);



?>

<h2>Editar descargo refrigerio</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Descargo refrigerio
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_descargo_refrigerio" id="frm_asistencia" action="control/descargo_refrigerio/editar_descargo_refrigerio.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_descargo_refrigerio" id="id_descargo_refrigerio" class="form-control required text" value='<?php echo $descargo_refrigerio->id_descargo_refrigerio; ?>'/>
			
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->gestion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ".$trabajador->apellido_materno." ".$trabajador->nombres); ?>'readonly/>
				</div>
			</div>	
			<div class="form-group">
				<label for="dias_laborables" class="col-sm-3 control-label">D&iacute;as laborables</label>
				<div class="col-sm-5">
					<input type="text" name="dias_laborables" id="dias_laborables" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($asistencia_refrigerio->dias_laborables); ?>' readonly/>
				</div>
			</div>

			<div class="form-group">
				<label for="dias_asistencia" class="col-sm-3 control-label">D&iacute;as asistencia</label>
				<div class="col-sm-5">
					<input type="text" name="dias_asistencia" id="dias_asistencia" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($asistencia_refrigerio->dias_asistencia); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_refrigerio" class="col-sm-3 control-label">Monto Refrigerio</label>
				<div class="col-sm-5">
					<input type="text" name="monto_refrigerio" id="monto_refrigerio" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->monto_refrigerio); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_descargo" class="col-sm-3 control-label">Monto facturas</label>
				<div class="col-sm-5">
					<input type="text" name="monto_descargo" id="monto_descargo" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->monto_descargo); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="retencion" class="col-sm-3 control-label">Retenci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="retencion" id="retencion" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->retencion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="total_refrigerio" class="col-sm-3 control-label">Total refrigerio</label>
				<div class="col-sm-5">
					<input type="text" name="total_refrigerio" id="total_refrigerio" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($descargo_refrigerio->total_refrigerio); ?>' readonly/>
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
