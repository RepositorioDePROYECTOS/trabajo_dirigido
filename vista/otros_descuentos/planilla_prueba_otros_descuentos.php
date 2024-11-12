<?php
	include("modelo/descuentos.php");
	$descuentos = new descuentos();
	$mes = $_GET[mes];
	$gestion = $_GET[gestion];
	$registros = $bd->Consulta("select * from conf_otros_descuentos where estado='HABILITADO'");
?>
<h2>Cargar Planilla Prueba Otros Descuentos</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Descuentos
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_otros_descuentos" id="frm_otros_descuentos" action="control/otros_descuentos/generar_planilla_prueba_otros_descuentos.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
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
				<label for="id_conf_otros_descuentos" class="col-sm-3 control-label">Descuento</label>
				<div class="col-sm-5">
					<select name="id_conf_otros_descuentos" id="id_conf_otros_descuentos" class="form-control required select">
						<option value="">--Seleccione--</option>
						<?php
						while($registro = $bd->getFila($registros))
						{
							echo utf8_encode("<option value='$registro[id_conf_otros_descuentos]'>$registro[descripcion]</option>");
						}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="a_quienes" class="col-sm-3 control-label">A quienes?</label>
				<div class="col-sm-5">
					<select name="a_quienes" id="a_quienes" class="form-control required select">
						<option value="1" selected>Trabajdores Sindicalizados</option>
						<option value="0">Todos los trabajadores</option>
						<option value="2">No Sindicalizados</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="de_donde" class="col-sm-3 control-label">De donde?</label>
				<div class="col-sm-5">
					<select name="de_donde" id="de_donde" class="form-control required select">
						<option value="2">Salario B&aacute;sico</option>
					</select>
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
