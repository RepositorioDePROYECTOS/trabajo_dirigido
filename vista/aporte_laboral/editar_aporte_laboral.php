
<?php

	include("modelo/aporte_laboral.php");
    
    $id = security($_GET[id]);

    $aporte_laboral = new aporte_laboral();

    $aporte_laboral->get_aporte_laboral($id);

?>

<h2>Editar Aporte Laboral</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Aporte Laboral
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_aporte_laboral" id="frm_aporte_laboral" action="control/aporte_laboral/editar_aporte_laboral.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_aporte_laboral" id="id_aporte_laboral" class="form-control required text" value='<?php echo $aporte_laboral->id_aporte_laboral; ?>'/>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aporte_laboral->mes); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aporte_laboral->gestion); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Tipo Aporte</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_aporte" id="tipo_aporte" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aporte_laboral->tipo_aporte); ?>'readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="porc_aporte" class="col-sm-3 control-label">Porcentaje Aporte</label>
				<div class="col-sm-5">
					<input type="text" name="porc_aporte" id="porc_aporte" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aporte_laboral->porc_aporte); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_aporte" class="col-sm-3 control-label">Monto Aporte</label>
				<div class="col-sm-5">
					<input type="text" name="monto_aporte" id="monto_aporte" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($aporte_laboral->monto_aporte); ?>'/>
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
