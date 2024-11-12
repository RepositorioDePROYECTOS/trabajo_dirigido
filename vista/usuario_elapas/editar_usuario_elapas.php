<?php
	include("modelo/usuario_externo.php");
	include("modelo/expediente.php");
    // Valores de usuario Externo
    $id = security($_GET[id]);
    $usuario_externo = new usuario_externo();
    $usuario_externo->get_usuario_externo($id);
	// Valores de Expedientes
	$id_ex = security($_GET[id_ex]);
	$expediente = new expediente();
	$expediente ->get_expediente($id_ex);
    
?>
<h2>Editar Usuario Elapas</h2>
<br />
<div class="panel panel-default panel-shadow  col-sm-6" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Usuario Elapas
  		</div>
  	</div>
	  <div class="panel-body">
		<form name="frm_usuario_externo" id="frm_usuario_externo" action="control/usuario_externo/editar_usuario_externo.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_user_ex" id="id_user_ex" value="<?php echo $usuario_externo->id_user_ex; ?>"/>
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre de usuario</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text" value="<?php echo $usuario_externo->nombre; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="documento" class="col-sm-3 control-label">Documento</label>
				<div class="col-sm-5">
					<input type="text" name="documento" id="documento" class="form-control required text" value="<?php echo $usuario_externo->documento; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direccion</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text" value="<?php echo $usuario_externo->direccion; ?>" /></td>
				</div>
			</div>


			

	</div>
</div>
<!-- Edicion Expediente-->
<div class="panel panel-default panel-shadow  col-sm-6" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Expediente
  		</div>
  	</div>
	  <div class="panel-body">
			<input type="hidden" name="id_expediente" id="id_expediente" value="<?php echo $expediente->id_expediente; ?>"/>
			<div class="form-group">
				<label for="nr_fojas" class="col-sm-3 control-label">Numero de Hojas</label>
				<div class="col-sm-5">
					<input type="text" name="nr_fojas" id="nr_fojas" class="form-control required text" value="<?php echo $expediente->nr_fojas; ?>" /></td>
				</div>
			</div><br><br>
			<div class="form-group">
				<label for="codigo_catastral" class="col-sm-3 control-label">Codigo Catastral</label>
				<div class="col-sm-5">
					<input type="text" name="codigo_catastral" id="codigo_catastral" class="form-control required text" value="<?php echo $expediente->codigo_catastral; ?>" /></td>
				</div>
			</div><br><br><br><br>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
