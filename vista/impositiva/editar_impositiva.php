
<?php

	include("modelo/impositiva.php");
    
    $id = security($_GET[id]);

    $impositiva = new impositiva();

    $impositiva->get_impositiva($id);

    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join impositiva i on ac.id_asignacion_cargo=i.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where i.id_impositiva=$id");
    $registro = $bd->getFila($registros);
?>

<h2>Editar Impositiva</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Impositiva
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_impositiva" id="frm_impositiva" action="control/impositiva/editar_impositiva.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_impositiva" id="id_impositiva" class="form-control required text" value='<?php echo $impositiva->id_impositiva; ?>'/>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
					<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($impositiva->mes);?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($impositiva->gestion);?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="trabajador" class="col-sm-3 control-label">Trabajador</label>
				<div class="col-sm-5">
					<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres]);?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="presentacion_desc" class="col-sm-3 control-label">13 % Formulario F110</label>
				<div class="col-sm-5">
					<input type="text" name="presentacion_desc" id="presentacion_desc" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($impositiva->presentacion_desc); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="saldo_mes_anterior" class="col-sm-3 control-label">Saldo mes anterior</label>
				<div class="col-sm-5">
					<input type="text" name="saldo_mes_anterior" id="saldo_mes_anterior" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($impositiva->saldo_mes_anterior); ?>'/>
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
