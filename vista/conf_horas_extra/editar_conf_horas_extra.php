
<?php

	include("modelo/conf_horas_extra.php");
    
    $id_conf_horas_extra = security($_GET[id]);

    $conf_horas_extra = new conf_horas_extra();

    $conf_horas_extra->get_conf_horas_extra($id_conf_horas_extra);

?>

<h2>Editar Hora Extra</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Hora Extra
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_conf_horas_extra" id="frm_conf_horas_extra" action="control/conf_horas_extra/editar_conf_horas_extra.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_horas_extra" id="id_conf_horas_extra" class="form-control required text" value='<?php echo $conf_horas_extra->id_conf_horas_extra; ?>'/>
			<div class="form-group">
				<label for="tipo_he" class="col-sm-3 control-label">Tipo de hora extra</label>
				<div class="col-sm-5">
					<input type="text" name="tipo_he" id="tipo_he" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_horas_extra->tipo_he); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="factor_calculo" class="col-sm-3 control-label">Factor de calculo</label>
				<div class="col-sm-5">
					<input type="text" name="factor_calculo" id="factor_calculo" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($conf_horas_extra->factor_calculo); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<?php
						if($conf_horas_extra->estado == 'HABILITADO')
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
