
<?php

	include("modelo/conf_refrigerio.php");
    
    $id_conf_refrigerio = security($_GET[id]);

    $conf_refrigerio = new conf_refrigerio();

    $conf_refrigerio->get_conf_refrigerio($id_conf_refrigerio);

?>

<h2>Editar Refrigerio</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Refrigerio
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_refrigerio" id="frm_refrigerio" action="control/conf_refrigerio/editar_conf_refrigerio.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_conf_refrigerio" id="id_conf_refrigerio" class="form-control required text" value='<?php echo $conf_refrigerio->id_conf_refrigerio; ?>'/>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($conf_refrigerio->descripcion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto_refrigerio" class="col-sm-3 control-label">Monto Refrigerio</label>
				<div class="col-sm-5">
					<input type="text" name="monto_refrigerio" id="monto_refrigerio" class="form-control required enteros" value='<?php echo utf8_encode($conf_refrigerio->monto_refrigerio); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_refrigerio" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="estado_refrigerio" id="estado_refrigerio" class="form-control required select">
						<?php
						if($conf_refrigerio->estado_refrigerio == 'HABILITADO')
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
