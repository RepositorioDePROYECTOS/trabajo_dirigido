
<?php
	include("modelo/vacacion.php");
	include("modelo/detalle_vacacion.php");
	include("modelo/trabajador.php");
	include("modelo/asignacion_cargo.php");
    
    $id_detalle_vacacion = security($_GET[id]);

    $vacacion = new vacacion();
    $detalle_vacacion = new detalle_vacacion();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $detalle_vacacion->get_detalle_vacacion($id_detalle_vacacion);
    $vacacion->get_vacacion($detalle_vacacion->id_vacacion);

    $trabajador->get_trabajador($vacacion->id_trabajador);



?>

<h2>Editar Detalle Vacaci&oacute;n</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Detalle Vacaci&oacute;n
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_detalle_vacacion" id="frm_detalle_vacacion" action="control/detalle_vacacion/editar_detalle_vacacion.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_detalle_vacacion" id="id_detalle_vacacion" class="form-control required text" value='<?php echo $detalle_vacacion->id_detalle_vacacion; ?>'/>
					
			
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ".$trabajador->apellido_materno." ".$trabajador->nombres); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion_inicio" class="col-sm-3 control-label">Gesti&oacute;n inicio</label>
				<div class="col-sm-5">
					<input type="text" name="gestion_inicio" id="gestion_inicio" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($detalle_vacacion->gestion_inicio); ?>' readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="gestion_fin" class="col-sm-3 control-label">Gesti&oacute;n fin</label>
				<div class="col-sm-5">
					<input type="text" name="gestion_fin" id="gestion_fin" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($detalle_vacacion->gestion_fin); ?>' readonly />
				</div>
			</div>		
			<div class="form-group">
				<label for="fecha_calculo" class="col-sm-3 control-label">Fecha de Calculo</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_calculo" id="fecha_calculo" class="form-control required datepicker"  placeholder='' value='<?php echo utf8_encode($detalle_vacacion->fecha_calculo);?>' readonly disabled/>
				</div>
			</div>
			<div class="form-group">
				<label for="cantidad_dias" class="col-sm-3 control-label">Cantidad d&iacute;as</label>
				<div class="col-sm-5">
					<input type="text" name="cantidad_dias" id="cantidad_dias" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($detalle_vacacion->cantidad_dias); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_utilizados" class="col-sm-3 control-label">D&iacute;as utilizados</label>
				<div class="col-sm-5">
					<input type="text" name="dias_utilizados" id="dias_utilizados" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($detalle_vacacion->dias_utilizados);?>'/>
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
