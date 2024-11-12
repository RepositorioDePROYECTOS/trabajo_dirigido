<h2>Crear Estante</h2>
<?php
include("modelo/tipo_estante.php");
$registros = $bd->Consulta("select * from tipo_estante");
?>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Estante
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_estante" id="frm_estante" action="control/estante/insertar_estante.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nro. Estante</label>
				<div class="col-sm-5">
					<input type="text" name="nro_estante" id="nro_estante" class="form-control required enteros" data-validate="required"  data-message-required="Escriba el correo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nro. Filas</label>
				<div class="col-sm-5">
					<input type="text" name="nro_filas" id="nro_filas" class="form-control required enteros" data-validate="required"  data-message-required="numero de filas" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_tipo_estante" class="col-sm-3 control-label">Tipo de estante</label>
				<div class="col-sm-5">
					<select name="id_tipo_estante" id="id_tipo_estante" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								echo "<option value='$registro[id_tipo_estante]'>$registro[categoria]</option>";
							}
						?>
						
					</select>
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
