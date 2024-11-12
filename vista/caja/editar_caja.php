<?php
	include("modelo/caja.php");
    
	$registros_nivel = $bd->Consulta("select * from estante");
    $id = security($_GET[id]);
    $caja = new caja();
    $caja->get_caja($id);
    
?>
<h2>Editar Caja</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Caja
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_caja" id="frm_caja" action="control/caja/editar_caja.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_caja" id="id_caja" value="<?php echo $caja->id_caja; ?>"/>
            
			<div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Codigo</label>
				<div class="col-sm-5">
					<input type="text" name="codigo" id="codigo" class="form-control required text"  value="<?php  echo $caja->codigo; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_estante" class="col-sm-3 control-label">Identificador de Estante</label>
				<div class="col-sm-5">					
					<select name="id_caja" id="id_caja" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_nivel = $bd->getFila($registros_nivel))
							{
								echo "<option value='$registro_nivel[id_estante]'>$registro_nivel[nombre]</option>";
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