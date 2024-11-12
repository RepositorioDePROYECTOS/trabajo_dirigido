
<?php

	include("modelo/otros_descuentos.php");
    
    $id = security($_GET[id]);

    $otros_descuentos = new otros_descuentos();

    $otros_descuentos->get_otros_descuentos($id);

    $trabajadores = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.id_asignacion_cargo=$otros_descuentos->id_asignacion_cargo");
    $trabajador = $bd->getFila($trabajadores);
?>

<h2>Editar otro descuento</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Otro descuento
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_otros_descuento" id="frm_otros_descuento" action="control/otros_descuentos/editar_otros_descuentos.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_otros_descuentos" id="id_otros_descuentos" class="form-control required text" value='<?php echo $otros_descuentos->id_otros_descuentos; ?>'/>
					<input type="hidden" name="factor_calculo" id="factor_calculo" class="form-control required text" value='<?php echo $otros_descuentos->factor_calculo; ?>'/>
					<input type="hidden" name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required text" value='<?php echo $otros_descuentos->id_asignacion_cargo; ?>'/>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($otros_descuentos->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($otros_descuentos->gestion); ?>' readonly/>
				</div>
			</div>

			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador[apellido_paterno]." ".$trabajador[apellido_materno]." ".$trabajador[nombres]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descuento</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($otros_descuentos->descripcion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_od" class="col-sm-3 control-label">Monto</label>
				<div class="col-sm-5">
					<input type="text" name="monto_od" id="monto_od" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($otros_descuentos->monto_od); ?>'/>
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
