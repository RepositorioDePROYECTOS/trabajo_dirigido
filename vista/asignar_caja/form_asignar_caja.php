<?php
	include("modelo/caja.php");
	$id_fila = $_GET[id_fila];
?>
<h2>Crear Caja</h2>
<br />
<?php ?>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nueva Caja
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_caja" id="frm_caja" action="control/caja/insertar_caja.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nro_caja" class="col-sm-3 control-label">Numero Caja</label>
				<div class="col-sm-5">
					<input type="text" name="nro_caja" id="nro_caja" class="form-control required enteros" data-validate="required"  data-message-required="Escriba el numero" placeholder=''/></td>
				</div>
			</div>
			<input type="hidden" name="id_fila" id="id_fila" value="<?php echo $id_fila; ?>"
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
