<?php 
    $id_partida = security($_GET[id]);
    // echo $id_partida;
?>
<h2>Crear Concepto</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Concepto
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_estante" id="frm_estante" action="control/partidas_detalle/insertar.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<input type="hidden" name="id_partida" id="id_partida" value="<?php echo $id_partida; ?>">
            <div class="form-group">
				<label for="concepto_partida" class="col-sm-3 control-label">Concepto de Partida</label>
				<div class="col-sm-5">
					<input type="text" name="concepto_partida" id="concepto_partida" class="form-control required" data-validate="required"  data-message-required="Escriba el Concepto de Partida" placeholder=''/></input>
				</div>
			</div>
			<div class="form-group">
				<label for="tipo_detalle_partida" class="col-sm-3 control-label">Tipo de Detalle de Partida</label>
				<div class="col-sm-5">
					<select name="tipo_detalle_partida" id="tipo_detalle_partida" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<option value="CLASIFICADOR">CLASIFICADOR</option>
						<option value="ELAPAS">ELAPAS</option>
						<option value="SICOES">SICOES</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>