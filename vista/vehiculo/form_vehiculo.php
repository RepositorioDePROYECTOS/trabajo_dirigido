<?php
	include("modelo/vehiculo.php");
	include("modelo/salida.php");
?>
<h2>Agregar Vehiculo</h2>
<br />
<?php ?>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nueva Vehiculo
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_vehiculo" id="frm_vehiculo" action="control/vehiculo/insertar_vehiculo.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="placa" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-5">
					<input type="text" name="placa" id="placa" class="form-control required text" data-validate="required"  data-message-required="Escriba el codigo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="marca" class="col-sm-3 control-label">Marca</label>
				<div class="col-sm-5">
					<input type="text" name="marca" id="marca" class="form-control required text" data-validate="required"  data-message-required="Escriba el codigo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="modelo" class="col-sm-3 control-label">Modelo</label>
				<div class="col-sm-5">
					<input type="text" name="modelo" id="modelo" class="form-control required text" data-validate="required"  data-message-required="Escriba el codigo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
