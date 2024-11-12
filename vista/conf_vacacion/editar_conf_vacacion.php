
<?php

	include("modelo/conf_bono_antiguedad.php");
    
    $id_conf_bono_antiguedad = security($_GET[id]);

    $conf_bono_antiguedad = new conf_bono_antiguedad();

    $conf_bono_antiguedad->get_conf_bono_antiguedad($id_conf_bono_antiguedad);

?>

<h2>Editar Bono</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Bono
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_bono_antiguedad" id="frm_bono_antiguedad" action="control/conf_bono_antiguedad/editar_conf_bono_antiguedad.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_bono_antiguedad" id="id_conf_bono_antiguedad" class="form-control required text" value='<?php echo $conf_bono_antiguedad->id_conf_bono_antiguedad; ?>'/>
			<div class="form-group">
				<label for="anio_i" class="col-sm-3 control-label">A&ntilde;o inicio</label>
				<div class="col-sm-5">
					<input type="text" name="anio_i" id="anio_i" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($conf_bono_antiguedad->anio_i); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="anio_f" class="col-sm-3 control-label">A&ntilde;o fin</label>
				<div class="col-sm-5">
					<input type="text" name="anio_f" id="anio_f" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($conf_bono_antiguedad->anio_f); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="porcentaje" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje" id="porcentaje" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($conf_bono_antiguedad->porcentaje); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="estado_bono" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado_bono" id="estado_bono" class="form-control required select">
						<?php
						if($conf_bono_antiguedad->estado_bono == 'HABILITADO')
						{
							echo "<option value='HABILITADO' selected> HABILITADO</option><option value='INHABILITADO'> INHABILITADO</option>";
						}
						else
						{
							echo "<option value='HABILITADO'> HABILITADO</option><option value='INHABILITADO' selected> INHABILITADO</option>";
						}
						?>
						
					</select>
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
