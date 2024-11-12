<h2>Crear Tipo de Estante</h2>
<?php
include("modelo/tipo_estante.php");
$registros = $bd->Consulta("select * from tipo_estante");
?>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Tipo Estante
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_tipo_estante" id="frm_tipo_estante" action="control/tipo_estante/insertar_tipo_estante.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<label for="categoria" class="col-sm-3 control-label">Nombre de la Categoria</label>
				<div class="col-sm-5">
					<input type="text" name="categoria" id="categoria" class="form-control required text" data-validate="required"  data-message-required="Escriba el correo" placeholder=''/></td>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text" data-validate="required"  data-message-required="Escriba el cuenta" placeholder=''/></td>
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
