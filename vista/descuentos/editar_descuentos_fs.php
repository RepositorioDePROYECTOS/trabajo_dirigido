
<?php

	include("modelo/descuentos.php");
    
    $id = security($_GET[id]);

    $descuentos = new descuentos();

    $descuentos->get_descuentos($id);

    $trabajadores = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.id_asignacion_cargo=$descuentos->id_asignacion_cargo");
    $trabajador = $bd->getFila($trabajadores);
?>

<h2>Editar descuento</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Descuento
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_descuento_fs" id="frm_descuento" action="control/descuentos/editar_descuentos_fs.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_descuentos" id="id_descuentos" class="form-control required text" value='<?php echo $descuentos->id_descuentos; ?>'/>
					<input type="hidden" name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required text" value='<?php echo $descuentos->id_asignacion_cargo; ?>'/>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($descuentos->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($descuentos->gestion); ?>' readonly/>
				</div>
			</div>

			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador[apellido_paterno]." ".$trabajador[apellido_materno]." ".$trabajador[nombres]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_descuento" class="col-sm-3 control-label">Descuento</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_descuento" id="nombre_descuento" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($descuentos->nombre_descuento); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto" class="col-sm-3 control-label">Cantidad horas a descontar</label>
				<div class="col-sm-5">
					<input type="text" name="monto" id="monto" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($descuentos->monto); ?>'/>
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
