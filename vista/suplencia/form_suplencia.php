<?php
	include("modelo/asignacion_cargo.php");

	$mes = $_GET[mes];
	$gestion = $_GET[gestion];

	$asignacion_cargo = new asignacion_cargo();
	
	$trabajadores = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='HABILITADO'");
	$suplencias = $bd->Consulta("select * from cargo order by item asc");
?>
<h2>Registrar suplencia</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Suplencia
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_suplencia" id="frm_suplencia" action="control/suplencia/insertar_suplencia.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<label for="fecha_inicio" class="col-sm-3 control-label">Fecha inicio</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control required datepicker" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_fin" class="col-sm-3 control-label">Fecha fin</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_fin" id="fecha_fin" class="form-control required datepicker" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="total_dias" class="col-sm-3 control-label">Total d&iacute;as</label>
				<div class="col-sm-5">
					<input type="text" name="total_dias" id="total_dias" class="form-control required decimales" autocomplete="off"/>
				</div>
			</div>
			<div class="form-group">
				<label for="id_cargo_suplencia" class="col-sm-3 control-label">Cargo Suplencia</label>
				<div class="col-sm-5">
					<select name="id_cargo_suplencia" id="id_cargo_suplencia" class="form-control required select2">
						<option value="">--Seleccione--</option>
						<?php
							while($suplencia = $bd->getFila($suplencias))
							{
								echo "<option value='$suplencia[id_cargo]'>($suplencia[item])".utf8_encode($suplencia[descripcion])."($suplencia[salario_mensual])</option>";
							}
						?>
					</select>
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
