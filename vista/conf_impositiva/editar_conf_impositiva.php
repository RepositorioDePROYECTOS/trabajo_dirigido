
<?php

	include("modelo/conf_impositiva.php");
    
    $id_conf_impositiva = security($_GET[id]);

    $conf_impositiva = new conf_impositiva();

    $conf_impositiva->get_conf_impositiva($id_conf_impositiva);

?>

<h2>Editar Impositiva</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Impositiva
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_impositiva" id="frm_impositiva" action="control/conf_impositiva/editar_conf_impositiva.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_impositiva" id="id_conf_impositiva" class="form-control required text" value='<?php echo $conf_impositiva->id_conf_impositiva; ?>'/>
			<div class="form-group">
				<label for="salario_minimo" class="col-sm-3 control-label">Salario minimo</label>
				<div class="col-sm-5">
					<input type="text" name="salario_minimo" id="salario_minimo" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($conf_impositiva->salario_minimo); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="cant_sm" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-5">
					<input type="text" name="cant_sm" id="cant_sm" class="form-control required enteros" value='<?php echo utf8_encode($conf_impositiva->cant_sm); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje_imp" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje_imp" id="porcentaje_imp" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($conf_impositiva->porcentaje_imp); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<?php
						if($conf_impositiva->estado == 'HABILITADO')
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
