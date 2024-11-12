<?php
	include("modelo/usuario.php");
    
    $id = security($_GET[id]);
    $usuario = new usuario();
    $usuario->get_usuario($id);
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
	$registros_r = $bd->Consulta("select * from rol  where estado_rol=1");
?>
<h2>Editar Usuario</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Usuario
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_usuario" id="frm_usuario" action="control/usuario/editar_usuario.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario->id_usuario; ?>"/>
            
            <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text" value="<?php echo $usuario->correo; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="cuenta" class="col-sm-3 control-label">Cuenta</label>
				<div class="col-sm-5">
					<input type="text" name="cuenta" id="cuenta" class="form-control required text" value="<?php echo $usuario->cuenta; ?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_ap" class="col-sm-3 control-label">Nombres y Apellidos</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_ap" id="nombre_ap" class="form-control required text" value="<?php echo utf8_encode($usuario->nombre_ap); ?>"/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-3 control-label">Contrase&ntilde;a</label>
				<div class="col-sm-5">
					<input type="password" name="password" id="password" class="form-control"/></td>
				</div>
			</div>

			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Rol</label>
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
					<button type="submit" class="btn btn-info">Guardar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
