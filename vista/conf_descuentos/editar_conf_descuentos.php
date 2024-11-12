
<?php

	include("modelo/conf_descuentos.php");
    
    $id_conf_descuentos = security($_GET[id]);

    $conf_descuentos = new conf_descuentos();

    $conf_descuentos->get_conf_descuentos($id_conf_descuentos);

?>

<h2>Editar descuento</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Descuento
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_conf_descuento" id="frm_conf_descuento" action="control/conf_descuentos/editar_conf_descuentos.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_descuentos" id="id_conf_descuentos" class="form-control required text" value='<?php echo $conf_descuentos->id_conf_descuentos; ?>'/>
			<div class="form-group">
				<label for="nombre_descuento" class="col-sm-3 control-label">Nombre descuento</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_descuento" id="nombre_descuento" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_descuentos->nombre_descuento); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required select">
						<?php
						if($conf_descuentos->estado == 'HABILITADO')
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
