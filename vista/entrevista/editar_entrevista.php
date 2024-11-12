
<?php

	include("modelo/participante.php");
	include("modelo/trabajador.php");
	$id = security($_GET[id]);
    // $postulante = new Postulante();
    $convocatoria = $bd->Consulta("SELECT * FROM convocatoria WHERE id_convocatoria = $id");
	$convocatoria = $bd->getFila($convocatoria);
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
		<form name="frm_entrevista" id="frm_entrevista" action="control/entrevista/editar_entrevista.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_convocatoria" id="id_convocatoria" class="form-control required text" value='<?php echo $convocatoria[id_convocatoria]; ?>'/>
					
			<div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Titulo Entrevista</label>
				<div class="col-sm-5">
					<input type="text" name="nombre" id="nombre" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($convocatoria[nombre_convocatoria]); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="mes" class="col-sm-3 control-label">Mes</label>
				<div class="col-sm-5">
				<select name="mes" id="mes" class="form-control required text">
						<option value="" disabled  selected>...Seleccione...</option>
						<option value="Enero">Enero</option>
						<option value="Febrero">Febrero</option>
						<option value="Marzo">Marzo</option>
						<option value="Abril">Abril</option>
						<option value="Mayo">Mayo</option>
						<option value="Junio">Junio</option>
						<option value="Julio">Julio</option>
						<option value="Agosto">Agosto</option>
						<option value="Septiembre">Septiembre</option>
						<option value="Octubre">Octubre</option>
						<option value="Noviembre">Noviembre</option>
						<option value="Diciembre">Diciembre</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="gestion" class="col-sm-3 control-label">Gestion</label>
				<div class="col-sm-5">
					<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($convocatoria[gestion_convocatoria]); ?>' readonly/>
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
