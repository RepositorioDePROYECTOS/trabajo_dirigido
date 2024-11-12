<h2>Crear Refrigerio</h2>
                      <br />
                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                      	<div class="panel-heading">
    				  		<div class="panel-title">
    							Refrigerio
    				  		</div>
    				  	</div>
	<div class="panel-body">
		<form name="frm_refrigerio" id="frm_refrigerio" action="control/refrigerio/insertar_refrigerio.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
					<button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
