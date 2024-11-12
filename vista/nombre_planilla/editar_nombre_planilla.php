
                    <?php

                    	include("modelo/nombre_planilla.php");
                        
                        $id = security($_GET[id]);

                        $nombre_planilla = new nombre_planilla();

                        $nombre_planilla->get_nombre_planilla($id);
   
                    ?>

        <h2>Editar Nombre planilla</h2>
                      <br />
                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                      	<div class="panel-heading">
    				  		<div class="panel-title">
    							Nombre planilla
    				  		</div>
    				  	</div>
	<div class="panel-body">
		<form name="frm_nombre_planilla" id="frm_nombre_planilla" action="control/nombre_planilla/editar_nombre_planilla.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_nombre_planilla" id="id_nombre_planilla" class="form-control required text" value='<?php echo $nombre_planilla->id_nombre_planilla; ?>'/>
		
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($nombre_planilla->mes); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gestion</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($nombre_planilla->gestion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_planilla" class="col-sm-3 control-label">Nombre planilla</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_planilla" id="nombre_planilla" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($nombre_planilla->nombre_planilla); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_creacion" class="col-sm-3 control-label">Fecha creacion</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_creacion" id="fecha_creacion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($nombre_planilla->fecha_creacion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<input type="text" name="estado" id="estado" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($nombre_planilla->estado); ?>'/>
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
