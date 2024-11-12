<?php
	include("modelo/telefono.php");
    include("modelo/trabajador.php");
	
	$registros_nivel = $bd->Consulta("select * from trabajador");
    $id = security($_GET[id]);
	$id_trab=$_GET[id_trabajador];
    $telefono = new telefono();
    $telefono->get_telefono($id);
    
	// $trabajador = new trabajador()
?>
<h2>Editar Telefono</h2>
<br>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Telefono
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_telefono" id="frm_telefono" action="control/telefono/editar_telefono.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_telefono" id="id_telefono" value="<?php echo $telefono->id_telefono; ?>"/>
            
			<div class="form-group">
				<label for="telf_interno" class="col-sm-3 control-label">Telefono</label>
				<div class="col-sm-5">
					<input type="text" name="telf_interno" id="telf_interno" class="form-control required text" readonly value="<?php  echo $telefono->telf_interno; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">					
					<select name="id_trabajador" id="id_trabajador" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_nivel = $bd->getFila($registros_nivel))
							{
								if( $registro_nivel[id_trabajador] == $id_trab){
								echo "<option value='$registro_nivel[id_trabajador]' selected='selected'>$registro_nivel[nombre]</option>";
								}
								else{
									echo "<option value='$registro_nivel[id_trabajador]' >$registro_nivel[nombre]</option>";
								}
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