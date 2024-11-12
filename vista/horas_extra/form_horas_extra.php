<?php
	include("modelo/conf_horas_extra.php");

	$mes = $_GET[mes];
	$gestion = $_GET[gestion];

	$conf_horas_extra = new conf_horas_extra();
	$registros_he = $bd->Consulta("select * from conf_horas_extra");
	$trabajadores = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='HABILITADO'");
?>
<h2>Registrar hora extra</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Hora extra
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_hora_extra" id="frm_hora_extra" action="control/horas_extra/insertar_horas_extra.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<select name="mes" id="mes" class="form-control required select">
						<?php
						for ($i=1; $i < 13; $i++) 
						{ 
							if($mes==$i)
							{
								$nombre_mes = getMes($i);
								echo "<option value='$i' selected>$nombre_mes</option>";
							}
							else
							{
								$nombre_mes = getMes($i);
								echo "<option value='$i'>$nombre_mes</option>";
							}
						}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="id_asignacion_cargo" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<select name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required select2">
						<option value="">- Seleccione -</option>
						<?php
						while($trabajador=$bd->getFila($trabajadores))
						{
							echo utf8_encode("<option value='$trabajador[id_asignacion_cargo]'>$trabajador[apellido_paterno] $trabajador[apellido_materno] $trabajador[nombres]</option>");
						}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_conf_horas_extra" class="col-sm-3 control-label">Tipo de hora extra</label>
				<div class="col-sm-5">
					<select name="id_conf_horas_extra" id="id_conf_horas_extra" class="form-control required select">
						<option value="">--Seleccione--</option>
						<?php
							while($registro_he = $bd->getFila($registros_he))
							{
								echo "<option value='$registro_he[id_conf_horas_extra]'>$registro_he[tipo_he]</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-5">
					<input type="text" name="cantidad" id="cantidad" class="form-control required decimales" />
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
