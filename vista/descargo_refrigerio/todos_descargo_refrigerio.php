<?php
	include("modelo/descargo_refrigerio.php");
	$anio = $_REQUEST['gestion'];
	$mes = $_REQUEST['mes'];
	$descargo_refrigerio = new descargo_refrigerio();

	$registros = $bd->Consulta("select * from asistencia_refrigerio where mes=$mes and gestion=$anio");
	$registro = $bd->getFila($registros);

	
?>
<h2>Generar planilla descargo refrigerio</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Asistencia
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_todos_descargo_refrigerio" id="frm_todos_descargo_refrigerio" action="control/descargo_refrigerio/insertar_todos_descargo_refrigerio.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Generar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
