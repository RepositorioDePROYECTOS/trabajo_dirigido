<?php
	$anio = $_REQUEST['gestion'];
	$mes = $_REQUEST['mes'];
?>
<h2>Generar planilla refrigerio</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Refrigerio
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_todos_refrigerio" id="frm_todos_refrigerio" action="control/refrigerio/insertar_todos_refrigerio.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $anio;?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="dias_laborables" class="col-sm-3 control-label">D&iacute;as Computables</label>
				<div class="col-sm-5">
					<input type="text" name="dias_laborables" id="dias_laborables" class="form-control required enteros" value="30" />
				</div>
			</div>
			<div class="form-group">
				<label for="dias_asistencia" class="col-sm-3 control-label">D&iacute;as Asistencia</label>
				<div class="col-sm-5">
					<input type="text" name="dias_asistencia" id="dias_asistencia" class="form-control required enteros" value="30" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Generar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
