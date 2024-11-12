<?php
	include("modelo/fila.php");
	include("modelo/estante.php");
    $registros = $bd->Consulta("select * from fila");
	$id_estante = $_GET[id_estante];
	//$registros_nivel = $bd->Consulta("select * from caja")
?>
<h2>Crear Fila</h2>
<br />
<?php ?>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nueva fila
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_fila" id="frm_fila" action="control/fila/insertar_fila.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<input type="hidden" name="id_estante" id="id_estante" value="<?php echo $id_estante; ?>">
			<div class="form-group">
				<label for="nro_fila" class="col-sm-3 control-label">N&uacute;mero Fila</label>
				<div class="col-sm-5">
					<input type="text" name="nro_fila" id="nro_fila" class="form-control required enteros" data-validate="required"  data-message-required="Escriba el numero" placeholder=''/></td>
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
