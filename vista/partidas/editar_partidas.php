<?php
$id = security($_GET[id]);
$partidas_find = $bd->Consulta("SELECT * FROM partidas WHERE id_partida = $id");
$partida       = $bd->getFila($partidas_find);

?>
<h2>
	Editar Partida
	<a href="?mod=partidas&pag=index" class="btn btn-danger btn-icon" style="float: right;">
        Atras
        <i class="entypo-back"></i>
    </a>
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Partida
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_estante" id="frm_estante" action="control/partidas/actualizar.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<input type="hidden" name="id_partida" id="id_partida" value="<?php echo $id;?>">
			<div class="form-group">
				<label for="codigo_partida" class="col-sm-3 control-label">Codigo de Partida</label>
				<div class="col-sm-5">
					<input type="text" name="codigo_partida" id="codigo_partida" class="form-control required" data-validate="required"  data-message-required="Escriba el Codigo de Partida" value='<?php echo utf8_encode($partida[codigo_partida]);?>'/></input>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_partida" class="col-sm-3 control-label">Nombre de Partida</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_partida" id="nombre_partida" class="form-control required" data-validate="required"  data-message-required="Escriba el Nombre de Partida" value='<?php echo utf8_encode($partida[nombre_partida]);?>'/></input>
				</div>
			</div>
			<div class="form-group">
				<label for="glosa_partida" class="col-sm-3 control-label">Glosa de Partida</label>
				<div class="col-sm-5">
					<input type="text" name="glosa_partida" id="glosa_partida" class="form-control required" data-validate="required"  data-message-required="Escriba la Glosa de Partida" value='<?php echo utf8_encode($partida[glosa_partida]);?>'/></input>
				</div>
			</div>
			<div class="form-group">
				<label for="tipo_partida" class="col-sm-3 control-label">Tipo de Partida</label>
				<div class="col-sm-5">
					<select name="tipo_partida" id="tipo_partida" class="form-control required select2">
						<option value="" selected>--SELECCIONE--</option>
						<option value="FUNCIONAMIENTO">FUNCIONAMIENTO</option>
						<option value="INVERSIÓN">INVERSIÓN</option>
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