<?php
	$anio = date("Y");
?>
<h2>CREAR PLANILLA</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		PLANILLA
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_nombre_planilla" id="frm_nombre_planilla" action="control/nombre_planilla/insertar_nombre_planilla.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="numero_mes" class="col-sm-3 control-label">N&uacute;mero mes</label>
				<div class="col-sm-5">
					<select name="mes" id="mes" class="form-control required select">
						<option value="">--Seleccione--</option>
						<option value="1">ENERO</option>
						<option value="2">FEBRERO</option>
						<option value="3">MARZO</option>
						<option value="4">ABRIL</option>
						<option value="5">MAYO</option>
						<option value="6">JUNIO</option>
						<option value="7">JULIO</option>
						<option value="8">AGOSTO</option>
						<option value="9">SEPTIEMBRE</option>
						<option value="10">OCTUBRE</option>
						<option value="11">NOVIEMBRE</option>
						<option value="12">DICIEMBRE</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $anio;?>"/>
					
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_planilla" class="col-sm-3 control-label">Nombre planilla</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_planilla" id="nombre_planilla" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_creacion" class="col-sm-3 control-label">Fecha creaci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_creacion" id="fecha_creacion" class="form-control required datepicker"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<option value="ACTIVO" selected> ACTIVO</option>
						<option value="INACTIVO">INACTIVO</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
