<?php
$fecha = date("Y-m-d");
$id_usuario = $_GET[id_usuario];
include("modelo/asignacion_cargo.php");
$registros = $bd->Consulta("SELECT * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
$registros_g = $bd->Consulta("SELECT * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");

$registros_t = $bd->Consulta("SELECT * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join usuario u on t.id_trabajador=u.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where estado_asignacion='HABILITADO' and id_usuario=$id_usuario");
$registro_t = $bd->getFila($registros_t);
$seccion = "";
$nombre_solicitante = "";
$item_solicitante = "";
$cargo = "";
if($registro_t[item]){
	// echo "Hay";
	$registros_t = $bd->Consulta("SELECT * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join usuario u on t.id_trabajador=u.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where estado_asignacion='HABILITADO' and id_usuario=$id_usuario");
	while ($registro_t = $bd->getFila($registros_t)) {
		$seccion = utf8_encode($registro_t[seccion]);
		$nombre_solicitante = utf8_encode($registro_t[nombres] . " " . $registro_t[apellido_paterno] . " " . $registro_t[apellido_materno]);
		$item_solicitante = $registro_t[item];
		$cargo = utf8_encode($registro_t[cargo]);
	}
} else {
	// echo "no Hay";
	$registros_t = $bd->Consulta("SELECT * FROM usuario u INNER JOIN eventual e ON e.id_eventual = u.id_eventual WHERE u.id_usuario = $id_usuario");
	while($registro_t = $bd->getFila($registros_t)){
		$seccion = utf8_encode($registro_t[seccion]);
		$nombre_solicitante = utf8_encode($registro_t[nombres] . " " . $registro_t[apellido_paterno] . " " . $registro_t[apellido_materno]);
		$item_solicitante = $registro_t[item];
		$cargo = utf8_encode($registro_t[descripcion]);
	}
}

?>
<h2>CREAR SOLICITUD DE SERVICIO</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
			PLANILLA
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_solicitud_servicio" id="frm_solicitud_servicio" action="control/solicitud_servicio/insertar_solicitud_servicio.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<input type="hidden" name="id_usuario" id="id_usuario" class="form-control required text" value='<?php echo $id_usuario; ?>' />
			<input type="hidden" name="item_solicitante" id="item_solicitante" class="form-control required text" value='<?php echo $item_solicitante; ?>' />
			<div class="form-group">
				<label for="fecha_solicitud" class="col-sm-3 control-label">Fecha solicitud</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required datepicker" value="<?php echo $fecha; ?>" />

				</div>
			</div>
			<div class="form-group">
				<label for="nombre_solicitante" class="col-sm-3 control-label">Nombre solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control required text" value="<?php echo utf8_encode($nombre_solicitante); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="justificativo" class="col-sm-3 control-label">Justificativo</label>
				<div class="col-sm-5">
					<textarea name="justificativo" id="justificativo" class="form-control required text uppercase"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="objetivo_contratacion" class="col-sm-3 control-label">Objeto de Contratación</label>
				<div class="col-sm-5">
					<textarea name="objetivo_contratacion" id="objetivo_contratacion" class="form-control required text uppercase"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="oficina_solicitante" class="col-sm-3 control-label">Oficina solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="oficina_solicitante" id="oficina_solicitante" class="form-control required text" value="<?php echo $seccion; ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="autorizado_por" class="col-sm-3 control-label">Autorizado por:</label>
				<div class="col-sm-5">
					<select name="autorizado_por" id="autorizado_por" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
						while ($registro = $bd->getFila($registros)) {
							$nombre = $registro[nombres] . " " . $registro[apellido_paterno] . " " . $registro[apellido_materno];
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
						while ($registro_g = $bd->getFila($registros_g)) {
							$nombre = $registro_g[nombres] . " " . $registro_g[apellido_paterno] . " " . $registro_g[apellido_materno];
							echo "<option value='$nombre'>$registro_g[apellido_paterno] $registro_g[apellido_materno] $registro_g[nombres]</option>";
						}
						?>

					</select>
				</div>
			</div>
			<!-- <div class="form-group">
				<label for="tipo_solicitud" class="col-sm-3 control-label">Tipo Solicitud</label>
				<div class="col-sm-5">
					<select name="tipo_solicitud" id="tipo_solicitud" class="form-control required text-uppercase select2">
						<option value="">__SELECCIONE__</option>
						<option value="servicio">Orden de Servicio</option>
						<option value="contrato">Contrato</option>
					</select>
					<span class="text-uppercase font-italic bg-warning">Solicitudes menores a 20.000 BS. seleccione orden de Servicio, mayores a 20.000 BS. seleccione Contrato</span>
				</div>
			</div> -->

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>