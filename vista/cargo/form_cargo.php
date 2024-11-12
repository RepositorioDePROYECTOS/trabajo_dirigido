<h2>Crear Cargo</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Cargo
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_cargo" id="frm_cargo" action="control/cargo/insertar_cargo.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="item" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Nivel</label>
				<div class="col-sm-5">
					<input type="text" name="nivel" id="nivel" class="form-control required enteros"/>
				</div>
			</div>
			<div class="form-group">
				<label for="seccion" class="col-sm-3 control-label">Secci&oacute;n</label>
				<div class="col-sm-5">
					<select name="seccion" id="seccion" class="form-control required select">
						<option value="GERENCIA GENERAL" selected> GERENCIA GENERAL</option>
						<option value="GERENCIA TECNICA">GERENCIA TECNICA</option>
						<option value="CATASTRO DE REDES">CATASTRO DE REDES</option>
						<option value="CAPTACION Y ADUCCION">CAPTACION Y ADUCCION</option>
						<option value="PLANTA POTABILIZADORA DE AGUA">PLANTA POTABILIZADORA DE AGUA</option>
						<option value="CONTROL DE CALIDAD">CONTROL DE CALIDAD</option>
						<option value="RED DE AGUA POTABLE">RED DE AGUA POTABLE</option>
						<option value="INSTALACION Y CONEXIONES">INSTALACION Y CONEXIONES</option>
						<option value="RED DE ALCANTARILLADO">RED DE ALCANTARILLADO</option>
						<option value="PLANTA DE TRATAMIENTO Y AGUAS RESIDUALES">PLANTA DE TRATAMIENTO Y AGUAS RESIDUALES</option>
						<option value="GERENCIA ADMINISTRATIVA Y FINANCIERA">GERENCIA ADMINISTRATIVA Y FINANCIERA</option>
						<option value="GERENCIA COMERCIAL">GERENCIA COMERCIAL</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="salario_mensual" class="col-sm-3 control-label">Salario mensual</label>
				<div class="col-sm-5">
					<input type="text" name="salario_mensual" id="salario_mensual" class="form-control required decimales"/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_cargo" class="col-sm-3 control-label">Estado cargo</label>
				<div class="col-sm-5">
					<select name="estado_cargo" id="estado_cargo" class="form-control required select">
						<option value="HABILITADO" selected> HABILITADO</option>
						<option value="INHABILITADO">INHABILITADO</option>
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
