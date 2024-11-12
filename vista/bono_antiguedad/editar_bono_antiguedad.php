
<?php

	include("modelo/bono_antiguedad.php");
    
    $id = security($_GET[id]);

    $bono_antiguedad = new bono_antiguedad();

    $bono_antiguedad->get_bono_antiguedad($id);

?>

<h2>Editar Bono antiguedad</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Bono antiguedad
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_bono_antiguedad" id="frm_bono_antiguedad" action="control/bono_antiguedad/editar_bono_antiguedad.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_bono_antiguedad" id="id_bono_antiguedad" class="form-control required text" value='<?php echo $bono_antiguedad->id_bono_antiguedad; ?>'/>
			<div class="form-group">
				<label for="anios" class="col-sm-3 control-label">A&ntilde;os</label>
				<div class="col-sm-5">
					<input type="text" name="anios" id="anios" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($bono_antiguedad->anios); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje" class="col-sm-3 control-label">Porcentaje</label>
				<div class="col-sm-5">
					<input type="text" name="porcentaje" id="porcentaje" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($bono_antiguedad->porcentaje); ?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="monto" class="col-sm-3 control-label">Monto</label>
				<div class="col-sm-5">
					<input type="text" name="monto" id="monto" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($bono_antiguedad->monto); ?>'/>
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
