<?php
	include("modelo/telefono.php");
	include("modelo/trabajador.php");
    $registros = $bd->Consulta("select * from trabajador");
	$registros_c = $bd->Consulta("select * from cargo");
?>
<h2>Crear telefono</h2>
<br />
<?php ?>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo telefono
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_telefono" id="frm_telefono" action="control/telefono/insertar_telefono.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="telf_interno" class="col-sm-3 control-label">Telefono Interno</label>
				<div class="col-sm-5">
					<input type="text" name="telf_interno" id="telf_interno" class="form-control required text" data-validate="required"  data-message-required="Escriba el Telefono Interno" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
				<select name="id_trabajador" id="id_trabajador" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								echo utf8_encode("<option value='$registro[id_trabajador]'>$registro[nombres] $registro[apellido_paterno] $registro[apellido_materno]</option>");
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="cargo" class="col-sm-3 control-label">Cargo</label>
				<div class="col-sm-5">
				<select name="id_cargo" id="id_cargo" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_c = $bd->getFila($registros_c))
							{
								echo utf8_encode("<option value='$registro_c[id_cargo]'>$registro_c[descripcion]</option>");
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
