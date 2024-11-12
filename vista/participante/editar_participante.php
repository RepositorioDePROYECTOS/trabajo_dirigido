
<?php

	include("modelo/participante.php");
	include("modelo/trabajador.php");
	$id = security($_GET[id]);
    // $postulante = new Postulante();
    $postulante = $bd->Consulta("SELECT * FROM postulante WHERE id_postulante = $id");
	$postulantes = $bd->getFila($postulante);
?>
<h2>Editar Participante</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Postulante
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_participante" id="frm_participante" action="control/participante/editar_participante.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_postulante" id="id_postulante" class="form-control required text" value='<?php echo $postulantes[id_postulante]; ?>'/>
					
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($postulantes[nombre_postulante]); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="ci" class="col-sm-3 control-label">CI</label>
				<div class="col-sm-5">
					<input type="text" name="ci" id="ci" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($postulantes[ci_postulante]); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefono</label>
				<div class="col-sm-5">
					<input type="text" name="telefono" id="telefono" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($postulantes[telefono_postulante]); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-5">
					<input type="text" name="correo" id="correo" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($postulantes[correo_postulante]); ?>'/>
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
