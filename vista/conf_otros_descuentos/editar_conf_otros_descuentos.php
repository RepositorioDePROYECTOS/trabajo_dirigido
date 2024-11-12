
<?php

	include("modelo/conf_otros_descuentos.php");
    
    $id_conf_otros_descuentos = security($_GET[id]);

    $conf_otros_descuentos = new conf_otros_descuentos();

    $conf_otros_descuentos->get_conf_otros_descuentos($id_conf_otros_descuentos);

?>

<h2>Editar otro descuento</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Descuento
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_conf_otros_descuentos" id="frm_conf_otros_descuentos" action="control/conf_otros_descuentos/editar_conf_otros_descuentos.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_otros_descuentos" id="id_conf_otros_descuentos" class="form-control required text" value='<?php echo $conf_otros_descuentos->id_conf_otros_descuentos; ?>'/>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_otros_descuentos->descripcion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="factor_calculo" class="col-sm-3 control-label">Factor de calculo</label>
				<div class="col-sm-5">
					<input type="text" name="factor_calculo" id="factor_calculo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_otros_descuentos->factor_calculo); ?>'/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<?php
						if($conf_otros_descuentos->estado == 'HABILITADO')
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
