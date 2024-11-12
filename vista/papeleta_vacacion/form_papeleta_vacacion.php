
<?php

	include("modelo/detalle_vacacion.php");
    $id_detalle_vacacion = security($_GET[id]);

    $detalle_vacacion = new detalle_vacacion();
    $detalle_vacacion->get_detalle_vacacion($id_detalle_vacacion);
    $fecha = date("Y-m-d");

    $registros = $bd->Consulta("SELECT * 
		from detalle_vacacion dv 
		inner join vacacion v on v.id_vacacion=dv.id_vacacion 
		inner join trabajador t on t.id_trabajador=v.id_trabajador 
		where dv.id_detalle_vacacion=$id_detalle_vacacion");
    $registro = $bd->getFila($registros);

	$anteriores = $bd->Consulta("SELECT * FROM detalle_vacacion WHERE id_detalle_vacacion = $id_detalle_vacacion");
	$anterior = $bd->getFila($anteriores);
	$calculo = $anterior[cantidad_dias] - $anterior[dias_utilizados];

    $registros_t = $bd->Consulta("SELECT * from asignacion_cargo ac 
		inner join trabajador t on ac.id_trabajador=t.id_trabajador 
		where estado_asignacion='HABILITADO'");
?>

<h2>Registrar Papeleta de Vacaci&oacute;n</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Solicitud de Vacaci&oacute;n
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_papeleta_vacacion" id="frm_papeleta_vacacion" action="control/papeleta_vacacion/insertar_papeleta_vacacion.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_detalle_vacacion" id="id_detalle_vacacion" class="form-control required text" value='<?php echo $id_detalle_vacacion; ?>'/>
					<input type="hidden" name="restantes" id="restantes" value="<?php echo $calculo;?>">
			<div class="form-group">
				<label for="trabajador" class="col-sm-2 control-label">Trabajador</label>
				<div class="col-sm-4">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]);?>' readonly/>
				</div>
				<label for="fecha_solicitud" class="col-sm-1 control-label">Fecha de solicitud</label>
				<div class="col-sm-4">
					<input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control required datepicker"  placeholder=''  value='<?php echo $fecha;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion_inicio" class="col-sm-2 control-label">Periodo correspondiente</label>
				<div class="col-sm-4">
					<input type="text" name="gestion_inicio" id="gestion_inicio" class="form-control required enteros"  placeholder='' value='<?php echo $detalle_vacacion->gestion_inicio;?>' readonly/>
				</div>
				<label for="gestion_fin" class="col-sm-1 control-label">al</label>
				<div class="col-sm-4">
					<input type="text" name="gestion_fin" id="gestion_fin" class="form-control required enteros"  placeholder='' value='<?php echo $detalle_vacacion->gestion_fin;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_inicio" class="col-sm-2 control-label">De fechas</label>
				<div class="col-sm-4">
					<input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control required datepicker"  placeholder='' value='<?php echo $fecha;?>' readonly/>
				</div>
				<label for="fecha_fin" class="col-sm-1 control-label">al</label>
				<div class="col-sm-4">
					<input type="text" name="fecha_fin" id="fecha_fin" class="form-control required datepicker"  placeholder='' value='<?php echo $fecha;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_solicitados" class="col-sm-2 control-label">D&iacute;as solicitados</label>
				<div class="col-sm-4">
					<input type="text" name="dias_solicitados" id="dias_solicitados" class="form-control required decimales"  placeholder='' value='5'/>
				</div>
				<label for="autorizado_por" class="col-sm-1 control-label">Autorizado por</label>
				<div class="col-sm-4">
					<select name="autorizado_por" id="autorizado_por" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<?php
							while($registro_t = $bd->getFila($registros_t))
							{
								$nombre = $registro_t[nombres]." ".$registro_t[apellido_paterno]." ".$registro_t[apellido_materno];
								echo utf8_encode("<option value='$nombre'>$registro_t[apellido_paterno] $registro_t[apellido_materno] $registro_t[nombres]</option>");
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="observacion" class="col-sm-2 control-label">Observaci&oacute;n</label>
				<div class="col-sm-9">
					<textarea name="observacion" id="observacion" class="form-control required text"></textarea>
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
