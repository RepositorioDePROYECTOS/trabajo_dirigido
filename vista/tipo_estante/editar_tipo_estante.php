<?php
	include("modelo/tipo_estante.php");
    
    $id = security($_GET[id]);
    $tipo_estante = new tipo_estante();
    $tipo_estante->get_tipo_estante($id);
    
?>
<h2>Editar tipo_estante</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar tipo_estante
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_tipo_estante" id="frm_tipo_estante" action="control/tipo_estante/editar_tipo_estante.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_tipo_estante" id="id_tipo_estante" value="<?php echo $tipo_estante->id_tipo_estante; ?>"/>
            <!-- TODO: Continuar -->
			<div class="form-group">
				<label for="categoria" class="col-sm-3 control-label">Nombre de la categoria</label>
				<div class="col-sm-5">
					<input type="text" name="categoria" id="categoria" class="form-control required text"  value="<?php  echo $tipo_estante->categoria; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  value="<?php  echo $tipo_estante->descripcion; ?>" /></td>
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
