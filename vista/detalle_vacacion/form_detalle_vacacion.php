
<?php

	include("modelo/detalle_vacacion.php");
    include("modelo/vacacion.php");
    $id_vacacion = security($_GET[id]);

    $vacacion = new vacacion();
    $vacacion->get_vacacion($id_vacacion);
    $detalle_vacacion = new detalle_vacacion();
    $gestion_fin = date("Y");
    $gestion_inicio = $gestion_fin - 1;
    $fecha = date("Y-m-d");

    $registros = $bd->Consulta("select * from vacacion v inner join trabajador t on t.id_trabajador=v.id_trabajador where v.id_vacacion=$id_vacacion");
    $registro = $bd->getFila($registros);
?>

<h2>Registrar Vacaci&oacute;n</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Vacaci&oacute;n
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_detalle_vacacion" id="frm_detalle_vacacion" action="control/detalle_vacacion/insertar_detalle_vacacion.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_vacacion" id="id_vacacion" class="form-control required text" value='<?php echo $id_vacacion; ?>'/>
			
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]);?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion_inicio" class="col-sm-3 control-label">Gesti&oacute;n inicio</label>
				<div class="col-sm-5">
					<input type="text" name="gestion_inicio" id="gestion_inicio" class="form-control required enteros"  placeholder='' value='<?php echo $gestion_inicio;?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion_fin" class="col-sm-3 control-label">Gesti&oacute;n fin</label>
				<div class="col-sm-5">
					<input type="text" name="gestion_fin" id="gestion_fin" class="form-control required enteros"  placeholder='' value='<?php echo $gestion_fin;?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_calculo" class="col-sm-3 control-label">Fecha de calculo</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_calculo" id="fecha_calculo" class="form-control required datepicker"  placeholder=''  value='<?php echo $fecha;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="cantidad_dias" class="col-sm-3 control-label">Cantidad de D&iacute;as</label>
				<div class="col-sm-5">
					<input type="text" name="cantidad_dias" id="cantidad_dias" class="form-control required decimales"  placeholder='' value='<?php echo $vacacion->dias_vacacion;?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="dias_utilizados" class="col-sm-3 control-label">D&iacute;as utilizados</label>
				<div class="col-sm-5">
					<input type="text" name="dias_utilizados" id="dias_utilizados" class="form-control required decimales"  placeholder='' value='0'/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
