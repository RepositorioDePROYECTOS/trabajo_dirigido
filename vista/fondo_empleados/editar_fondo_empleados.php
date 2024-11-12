
<?php

	include("modelo/fondo_empleados.php");
    
    $id = security($_GET[id]);

    $fondo_empleados = new fondo_empleados();

    $fondo_empleados->get_fondo_empleados($id);

    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.id_asignacion_cargo=$fondo_empleados->id_asignacion_cargo");
    $registro = $bd->getFila($registros);

?>

<h2>Editar fondo de empleado</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Fondo de empleado
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_fondo_empleados" id="frm_fondo_empleados" action="control/fondo_empleados/editar_fondo_empleados.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_fondo_empleados" id="id_fondo_empleados" class="form-control required text" value='<?php echo $fondo_empleados->id_fondo_empleados; ?>'/>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->gestion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="total_ganado" class="col-sm-3 control-label">Total ganado</label>
				<div class="col-sm-5">
					<input type="text" name="total_ganado" id="total_ganado" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->total_ganado); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje_fe" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje_fe" id="porcentaje_fe" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->porcentaje_fe)."%"; ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_fe" class="col-sm-3 control-label">Descuento F.E.</label>
				<div class="col-sm-5">
					<input type="text" name="monto_fe" id="monto_fe" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->monto_fe); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="pago_deuda" class="col-sm-3 control-label">Pago deuda</label>
				<div class="col-sm-5">
					<input type="text" name="pago_deuda" id="pago_deuda" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($fondo_empleados->pago_deuda); ?>'/>
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
