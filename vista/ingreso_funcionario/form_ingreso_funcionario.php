
<?php
	session_start();
	include("modelo/ingreso_funcionario.php");
    $id_usuario = $_SESSION[id_usuario];

    $ingreso_funcionario = new ingreso_funcionario();

    $fecha = date("Y-m-d");

    $registros = $bd->Consulta("select * from usuario u inner join trabajador t on t.id_trabajador=u.id_trabajador where u.id_usuario=$id_usuario");
    $registro = $bd->getFila($registros);

    $registros_t = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
?>

<h2>Registrar Solicitud de Ingreso</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Solicitud de Ingreso
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_ingreso_funcionario" id="frm_ingreso_funcionario" action="control/ingreso_funcionario/insertar_ingreso_funcionario.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_usuario" id="id_usuario" class="form-control required text" value='<?php echo $id_usuario; ?>'/>
			
			<div class="form-group">
				
				<label for="fecha_registro" class="col-sm-2 control-label">Fecha de solicitud</label>
				<div class="col-sm-2">
					<input type="text" name="fecha_registro" id="fecha_registro" class="form-control required datepicker"  placeholder=''  value='<?php echo $fecha;?>' readonly/>
				</div>
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-3">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]);?>' readonly/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha ingreso</label>
				<div class="col-sm-2">
					<input type="text" name="fecha_ingreso" id="fecha_ingreso" class="form-control required datepicker"  placeholder='' value='<?php echo $fecha;?>' readonly/>
				</div>
				<label for="hora_inicio" class="col-sm-2 control-label">Hora ingreso</label>
				<div class="col-sm-2">
					<input type="time" name="hora_inicio" id="hora_inicio"/>
				</div>
				<label for="hora_fin" class="col-sm-2 control-label">Hora salida</label>
				<div class="col-sm-2">
					<input type="time" name="hora_fin" id="hora_fin"/>
				</div>
			</div>
			<div class="form-group">
				<label for="motivo_ingreso" class="col-sm-3 control-label">Motivo Ingreso</label>
				<div class="col-sm-3">
					<input type="text" name="motivo_ingreso" id="motivo_ingreso" class="form-control required text"  placeholder='' >
				</div>
				<label for="observacion" class="col-sm-1 control-label">Observaci&oacute;n</label>
				<div class="col-sm-4">
					<textarea name="observacion" id="observacion" class="form-control required text"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="autorizado_por" class="col-sm-3 control-label">Autorizado por</label>
				<div class="col-sm-5">
					<select name="autorizado_por" id="autorizado_por" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_t = $bd->getFila($registros_t))
							{
								$nombre = $registro_t[nombres]." ".$registro_t[apellido_paterno]." ".$registro_t[apellido_materno];
								echo utf8_encode("<option value='$registro_t[id_trabajador]'>$registro_t[apellido_paterno] $registro_t[apellido_materno] $registro_t[nombres]</option>");
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
