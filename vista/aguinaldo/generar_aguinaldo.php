<?php
	include("modelo/aguinaldo.php");
	$aguinaldo = new aguinaldo();
	$gestion = $_REQUEST['gestion'];
  	$nro_aguinaldo = $_REQUEST['nro_aguinaldo'];
	
?>
<h2>Generar Planilla Aguinaldos</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Planilla
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_aguinaldo" id="frm_planilla" action="control/aguinaldo/generar_aguinaldo.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nro_aguinaldo" class="col-sm-3 control-label">Nro. Aguinaldo</label>
				<div class="col-sm-5">
					<select name="nro_aguinaldo" id="nro_aguinaldo" class="form-control required select" readonly>
						<option value='1' selected>PRIMER</option>
						<option value='2'>SEGUNDO</option>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" readonly />
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
