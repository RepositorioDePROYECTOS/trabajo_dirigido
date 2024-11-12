<?php
	$mes = $_GET[mes];
	$gestion = $_GET[gestion];
?>
<h2>Cargar planilla total ganado</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Totales ganado
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_total_ganado" id="frm_total_ganado" action="control/total_ganado/generar_planilla_total_ganado.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<label for="total_dias" class="col-sm-3 control-label">D&iacute;as laborables</label>
				<div class="col-sm-5">
					<input type="text" name="total_dias" id="total_dias" class="form-control required enteros" value="30" />
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
