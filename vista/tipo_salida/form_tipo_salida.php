<h2>Crear Tipo de salida</h2>
<?php
include("modelo/tipo_salida.php");
$registros = $bd->Consulta("select * from tipo_salida");
?>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Tipo Salida
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_tipo_salida" id="frm_tipo_salida" action="control/tipo_salida/insertar_tipo_salida.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre de la Salida</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text" data-validate="required"  data-message-required="Escriba el correo" placeholder=''/></td>
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
