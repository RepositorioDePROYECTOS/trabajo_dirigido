<?php
	include("modelo/trabajador.php");
	$trabajador = new trabajador();
	$registros = $bd->Consulta("SELECT * from eventual where estado_eventual='HABILITADO' AND id_eventual NOT IN (
			SELECT id_eventual
			FROM usuario
		)");
	$registros_r = $bd->Consulta("SELECT * from rol  where estado_rol=1");
?>

<h2>Crear Usuario</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Usuario
  		</div>
  	</div> 

	<div class="panel-body">
		<form name="frm_usuario" id="frm_usuario" action="control/usuario/insertar_usuario_eventual.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="id_trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<select name="id_trabajador" id="id_trabajador" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								echo "<option value='$registro[id_eventual]'>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text" data-validate="required"  data-message-required="Escriba el correo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="cuenta" class="col-sm-3 control-label">Cuenta</label>
				<div class="col-sm-5">
					<input type="text" name="cuenta" id="cuenta" class="form-control required text" data-validate="required"  data-message-required="Escriba el cuenta" placeholder=''/></td>
				</div>
			</div>
			
			<div class="form-group">
				<label for="password" class="col-sm-3 control-label">Contrase&ntilde;a</label>
				<div class="col-sm-5">
					<input type="password" name="password" id="password" class="form-control required text" data-validate="required"  data-message-required="Escriba el password" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="id_rol" class="col-sm-3 control-label">Rol</label>
				<div class="col-sm-5">
					<select name="id_rol" id="id_rol" class="form-control required">
					<option value="" selected>--SELECCIONE--</option>
					<?php
						while($registro_r = $bd->getFila($registros_r))
						{
							echo "<option value='$registro_r[id_rol]'>$registro_r[nombre_rol]</option>";
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
