<?php
	include("modelo/nombre_planilla.php");
	$nombre_planilla = new nombre_planilla();
	$id_nombre_planilla = $_GET[id];
	$nombre_planilla->get_nombre_planilla($id_nombre_planilla);
	$mes = $nombre_planilla->mes;
	$gestion = $nombre_planilla->gestion;
?>
<h2>Cargar Planilla</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Planilla
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_planilla" id="frm_planilla" action="control/planilla/generar_planilla.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<select name="mes" id="mes" class="form-control required select" readonly>
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
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" readonly />
				</div>
			</div>
			<input type="hidden" name="id_nombre_planilla" value="<?php echo $id_nombre_planilla;?>">
			<div class="form-group">
				<label for="nombre_planilla" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_planilla" id="nombre_planilla" class="form-control required text" value="<?php echo $nombre_planilla->nombre_planilla;?>" readonly/>
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
