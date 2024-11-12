<?php
	include("modelo/estante.php");
    
	$registros_nivel = $bd->Consulta("select * from tipo_estante");
    $id = security($_GET[id]);
    $estante = new estante();
    $estante->get_estante($id);
    
?>
<h2>Editar Estante</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Estante
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_estante" id="frm_estante" action="control/estante/editar_estante.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_estante" id="id_estante" value="<?php echo $estante->id_estante; ?>"/>
            
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Codigo</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text"  value="<?php  echo $estante->nombre; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_tipo_estante" class="col-sm-3 control-label">Identificador tipo de Estante</label>
				<div class="col-sm-5">					
					<select name="id_tipo_estante" id="id_tipo_estante" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_nivel = $bd->getFila($registros_nivel))
							{
								echo "<option value='$registro_nivel[id_tipo_estante]'>$registro_nivel[categoria]</option>";
							}
						?>   	
					</select>
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
