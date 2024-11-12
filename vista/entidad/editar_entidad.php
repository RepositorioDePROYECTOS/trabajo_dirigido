
                    <?php
                    	include("modelo/entidad.php");
                        
                        $entidad = new entidad();

                        $entidad->get_entidad_defecto();
   
                    ?>

        <h2>Datos Generales</h2>
                      <br />
                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                      	<div class="panel-heading">
    				  		<div class="panel-title">
    							Datos
    				  		</div>
    				  	</div>
	<div class="panel-body">
		<form name="frm_entidad" id="frm_entidad" action="control/entidad/editar_entidad.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_entidad" id="id_entidad" class="form-control required text" value='<?php echo $entidad->id_entidad; ?>'/>
			<div class="form-group">
				<label for="nombre_entidad" class="col-sm-3 control-label">Nombre entidad</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_entidad" id="nombre_entidad" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($entidad->nombre_entidad); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="ubicacion" class="col-sm-3 control-label">Ubicaci&oacute;n Geogr&aacute;fica <br /><small>Latitud, Longitud</small></label>
				<div class="col-sm-5">
					<input type="text" name="ubicacion" id="ubicacion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($entidad->ubicacion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($entidad->direccion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="telefonos" class="col-sm-3 control-label">Tel&eacute;fonos</label>
				<div class="col-sm-5">
					<input type="text" name="telefonos" id="telefonos" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($entidad->telefonos); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($entidad->correo); ?>'/>
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
