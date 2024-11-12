<?php
	include("modelo/aporte_laboral.php");
	$aporte_laboral = new aporte_laboral();
	$mes = $_GET[mes];
	$gestion = $_GET[gestion];
?>
<h2>Cargar Planilla Aporte Laboral</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Aportes Laborales
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_cargo" id="frm_cargo" action="control/aporte_laboral/generar_planilla_aporte_laboral.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_calculo" class="col-sm-3 control-label">Fecha calculo</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_calculo" id="fecha_calculo" class="form-control required datepicker" readonly />
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
