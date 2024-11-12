<?php
	include("modelo/vehiculo.php");
    
    $id = security($_GET[id]);
    $vehiculo = new vehiculo();
    $vehiculo->get_vehiculo($id);
    
?>
<h2>Editar Vehiculo</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Vehiculo
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_vehiculo" id="frm_vehiculo" action="control/vehiculo/editar_vehiculo.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_vehiculo" id="id_vehiculo" value="<?php echo $vehiculo->id_vehiculo; ?>"/>
            <div class="form-group">
				<label for="placa" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-5">
					<input type="text" name="placa" id="placa" class="form-control required text" value="<?php echo $vehiculo->placa; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="marca" class="col-sm-3 control-label">Marca</label>
				<div class="col-sm-5">
					<input type="text" name="marca" id="marca" class="form-control required text" value="<?php echo $vehiculo->marca; ?>" /></td>
				</div>
			</div>	
			<div class="form-group">
				<label for="modelo" class="col-sm-3 control-label">Modelo</label>
				<div class="col-sm-5">
					<input type="text" name="modelo" id="modelo" class="form-control required text" value="<?php echo $vehiculo->modelo; ?>" /></td>
				</div>
			</div>		
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
