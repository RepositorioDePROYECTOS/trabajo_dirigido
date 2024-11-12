
<?php

	include("modelo/total_ganado.php");
    
    $id = security($_GET[id]);

    $total_ganado = new total_ganado();

    $total_ganado->get_total_ganado($id);

    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.id_asignacion_cargo=$total_ganado->id_asignacion_cargo");
    $registro = $bd->getFila($registros);

?>

<h2>Editar total ganado</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Total ganado
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_total_ganado" id="frm_total_ganado" action="control/total_ganado/editar_total_ganado.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_total_ganado" id="id_total_ganado" class="form-control required text" value='<?php echo $total_ganado->id_total_ganado; ?>'/>
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[item]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="cargo" class="col-sm-3 control-label">Cargo</label>
				<div class="col-sm-5">
					<input type="text" name="cargo" id="cargo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[cargo]); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="salario_mensual" class="col-sm-3 control-label">Salario mensual</label>
				<div class="col-sm-5">
					<input type="text" name="salario_mensual" id="salario_mensual" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($total_ganado->haber_mensual); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="total_dias" class="col-sm-3 control-label">D&iacute;as trabajado</label>
				<div class="col-sm-5">
					<input type="text" name="total_dias" id="total_dias" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($total_ganado->total_dias); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="salario_basico" class="col-sm-3 control-label">Salario B&aacute;sico</label>
				<div class="col-sm-5">
					<input type="text" name="salario_basico" id="salario_basico" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($total_ganado->haber_basico); ?>'/>
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
