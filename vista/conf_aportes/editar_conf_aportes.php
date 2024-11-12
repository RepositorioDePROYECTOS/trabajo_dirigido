
<?php

	include("modelo/conf_aportes.php");
    
    $id_conf_aporte = security($_GET[id]);

    $conf_aportes = new conf_aportes();

    $conf_aportes->get_conf_aportes($id_conf_aporte);

?>

<h2>Editar Aportes</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Aporte
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_cargo" id="frm_cargo" action="control/conf_aportes/editar_conf_aportes.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_aporte" id="id_conf_aporte" class="form-control required text" value='<?php echo $conf_aportes->id_conf_aporte; ?>'/>
			<div class="form-group">
				<label for="tipo_aporte" class="col-sm-3 control-label">Tipo de aporte</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_aporte" id="tipo_aporte" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_aportes->tipo_aporte); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="rango_inicial" class="col-sm-3 control-label">Rango inicial</label>
				<div class="col-sm-5">
					<input type="text" name="rango_inicial" id="rango_inicial" class="form-control required decimales" value='<?php echo utf8_encode($conf_aportes->rango_inicial); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="rango_final" class="col-sm-3 control-label">Rango final</label>
				<div class="col-sm-5">
					<input type="text" name="rango_final" id="rango_final" class="form-control required decimales" value='<?php echo utf8_encode($conf_aportes->rango_final); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="porc_aporte" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porc_aporte" id="Porcentaje" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($conf_aportes->porc_aporte); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<?php
						if($conf_aportes->estado == 'HABILITADO')
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
