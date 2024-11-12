<?php
	include("modelo/lavado.php");
	include("modelo/trabajador.php");
    $registros = $bd->Consulta("select * from trabajador");
	$registros_c = $bd->Consulta("select * from cargo");
	$fecha = date("Y-m-d");
	$id_usuario = $_GET[id_usuario];

	$registros_p =  $bd->Consulta("select * from vehiculo");

	$registros_t = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join usuario u on t.id_trabajador=u.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where estado_asignacion='HABILITADO' and id_usuario=$id_usuario");
	while($registro_t = $bd->getFila($registros_t))
		{
			$seccion = $registro_t[seccion];
			$nombre_solicitante = $registro_t[nombres]." ". $registro_t[apellido_paterno]." ".$registro_t[apellido_materno];
			$item_solicitante = $registro_t[item];
		}
?>
<h2>Crear solicitud de lavado</h2>
<br />

<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo lavado de Vehiculo
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_lavado" id="frm_lavado" action="control/lavado/insertar_lavado.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
		<input type="hidden" name="id_usuario" id="id_usuario" class="form-control required text" value='<?php echo $id_usuario;?>'/>	
			<div class="form-group">
				<label for="fecha_solicitud" class="col-sm-3 control-label">Fecha solicitud</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required datepicker" data-validate="required" value="<?php echo $fecha;?>" /></td>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_solicitante" class="col-sm-3 control-label">Nombre solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control required text" value="<?php echo utf8_encode($nombre_solicitante);?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="oficina_solicitante" class="col-sm-3 control-label">Oficina solicitante</label>
				<div class="col-sm-5">
					<input type="text" name="oficina_solicitante" id="oficina_solicitante" class="form-control required text" value="<?php echo $seccion;?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="vehiculo" class="col-sm-3 control-label">Vehiculo</label>
				<div class="col-sm-5">
				<select name="id_vehiculo" id="id_vehiculo" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_p = $bd->getFila($registros_p))
							{
								echo utf8_encode("<option value='$registro_p[id_vehiculo]'>$registro_p[placa] $registro_p[marca] $registro_p[modelo]</option>");
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="jefatura" class="col-sm-3 control-label">Jefatura</label>
				<div class="col-sm-5">
				<select name="jefatura" id="jefatura" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_c = $bd->getFila($registros_c))
							{
								echo utf8_encode("<option value='$registro_c[descripcion]'>$registro_c[descripcion]</option>");
							}
						?>
						


					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gerencia" class="col-sm-3 control-label">Gerencia</label>
				<div class="col-sm-5">
				<select name="gerencia" id="gerencia" class="form-control required select">
						<option value="" selected>--SELECCIONE--</option>
						<option value="GERENCIA GENERAL">GERENCIA GENERAL</option>
						<option value="GERENCIA ADMINISTRATIVA">GERENCIA ADMINISTRATIVA</option>
						<option value="GERENCIA COMERCIAL">GERENCIA COMERCIAL</option>
						<option value="GERENCIA TECNICA">GERENCIA TECNICA</option>
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
