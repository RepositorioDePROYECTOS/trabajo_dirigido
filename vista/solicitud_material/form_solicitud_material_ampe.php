<?php
	$fecha = date("Y-m-d");
	$id_usuario = $_GET[id_usuario];
	include("modelo/asignacion_cargo.php");
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
	$registros_g = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");

	$registros_t = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join usuario u on t.id_trabajador=u.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where estado_asignacion='HABILITADO' and id_usuario=$id_usuario");
	while($registro_t = $bd->getFila($registros_t))
		{
			$seccion = $registro_t[seccion];
			$nombre_solicitante = $registro_t[nombres]." ". $registro_t[apellido_paterno]." ".$registro_t[apellido_materno];
			$item_solicitante = $registro_t[item];
		}

?>
<h2>CREAR SOLICITUD MATERIAL</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		PLANILLA
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_solicitud_material" id="frm_solicitud_material" action="control/solicitud_material_ampe/insertar_solicitud_material_ampe.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
		<input type="hidden" name="id_usuario" id="id_usuario" class="form-control required text" value='<?php echo $id_usuario;?>'/>
		<input type="hidden" name="item_solicitante" id="item_solicitante" class="form-control required text" value='<?php echo $item_solicitante;?>'/>
			<div class="form-group">
				<label for="fecha_solicitud" class="col-sm-3 control-label">Fecha solicitud</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required datepicker" readonly value="<?php echo $fecha;?>"/>
					<input type="hidden" name="existencia_material" id="existencia_material" value="NO">
				</div>
				<!-- <label for="existencia_material" class="col-sm-1 control-label">Material con existencia</label>
				<div class="col-sm-2">
					<select name="existencia_material" id="existencia_material" class="form-control required select2">
						<option value="SI">SI</option>
						<option value="NO">NO</option>
					</select>
				</div> -->
			</div>
			<div class="form-group">
				<label for="programa_solicitud_material" class="col-sm-3 control-label">Programa</label>
				<div class="col-sm-2">
					<select name="programa_solicitud_material" id="programa_solicitud_material" class="form-control required" >
							<option value="" selected>--SELECCIONE--</option>
							<option value="00">00</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="41">41</option>
					</select>
				</div>
				<label for="actividad_solicitud_material" class="col-sm-1 control-label">Actividad</label>
				<div class="col-sm-2">
					<select name="actividad_solicitud_material" id="actividad_solicitud_material" class="form-control required">
							<option value="" selected>--SELECCIONE--</option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_solicitante" class="col-sm-3 control-label">Nombre solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control required text" value="<?php echo utf8_encode($nombre_solicitante);?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="justificativo" class="col-sm-3 control-label">Justificativo</label>
				<div class="col-sm-5">
					<textarea name="justificativo" id="justificativo" class="form-control required text uppercase" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="oficina_solicitante" class="col-sm-3 control-label">Oficina solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="oficina_solicitante" id="oficina_solicitante" class="form-control required text" value="<?php echo $seccion;?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="autorizado_por" class="col-sm-3 control-label">Autorizado por:</label>
				<div class="col-sm-5">
					<select name="autorizado_por" id="autorizado_por" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro = $bd->getFila($registros))
							{
								$nombre = $registro[nombres]." ". $registro[apellido_paterno]." ".$registro[apellido_materno];
								echo "<option value='$nombre'>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</option>";
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gerente_area" class="col-sm-3 control-label">Gerente de Área:</label>
				<div class="col-sm-5">
					<select name="gerente_area" id="gerente_area" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_g = $bd->getFila($registros_g))
							{
								$nombre = $registro_g[nombres]." ". $registro_g[apellido_paterno]." ".$registro_g[apellido_materno];
								echo "<option value='$nombre'>$registro_g[apellido_paterno] $registro_g[apellido_materno] $registro_g[nombres]</option>";
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="visto_bueno" class="col-sm-3 control-label">Visto Bueno:</label>
				<div class="col-sm-5">
				<input type="text" name="visto_bueno" id="visto_bueno" class="form-control required text" value="Ernesto Sejas"/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
