<?php
	include("modelo/conf_descuentos.php");
	$mes = $_GET[mes];
	$gestion = $_GET[gestion];
	$conf_descuentos = new conf_descuentos();
	$registros_d = $bd->Consulta("select * from conf_descuentos where estado='HABILITADO'");
	$registros_t = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where estado_asignacion='HABILITADO'");
?>
<h2>Crear descuento</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Descuento
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_descuento" id="frm_descuento" action="control/descuentos/insertar_descuentos.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required enteros" value="<?php echo $mes;?>" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required enteros" value="<?php echo $gestion;?>" readonly />
				</div>
			</div>
			<div class="form-group">
				<label for="id_asignacion_cargo" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<select name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required select2">
						<option value="">--Seleccione--</option>
						<?php
							while($registro_t = $bd->getFila($registros_t))
							{
								echo "<option value='$registro_t[id_asignacion_cargo]'>$registro_t[apellido_paterno] $registro_t[apellido_materno] $registro_t[nombres]</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_descuento" class="col-sm-3 control-label">Nombre descuento</label>
				<div class="col-sm-5">
					<select name="nombre_descuento" id="nombre_descuento" class="form-control required select">
						<option value="">--Seleccione--</option>
						<?php
							while($registro_d = $bd->getFila($registros_d))
							{
								echo "<option value='$registro_d[nombre_descuento]'>$registro_d[nombre_descuento]</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="monto" class="col-sm-3 control-label">Monto</label>
				<div class="col-sm-5">
					<input type="text" name="monto" id="monto" class="form-control required decimales"/>
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
