<?php
	include("modelo/expediente.php");
    
    $id = security($_GET[id]);
    $expediente = new expediente();
    $expediente->get_expediente($id);
    
?>
<h2>Editar Expediente</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Modificar Expediente
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_expediente" id="frm_expediente" action="control/expediente/editar_expediente.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
			<input type="hidden" name="id_expediente" id="id_expediente" value="<?php echo $expediente->id_expediente; ?>"/>
            <div class="form-group">
			<label for="fecha_registro" class="col-sm-3 control-label">Fecha Registro</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_registro" id="fecha_resgistro" class="form-control required datepicker"  placeholder=''  value='<?php echo $expediente->fecha_registro;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_archivo" class="col-sm-3 control-label">Nombre archivo</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_archivo" id="nombre_archivo" class="form-control required text" value="<?php echo $expediente->nombre_archivo;?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nro_fojas" class="col-sm-3 control-label">Numero de Fojas</label>
				<div class="col-sm-5">
					<input type="text" name="nro_fojas" id="nro_fojas" class="form-control required int" value="<?php echo $expediente->nro_fojas;?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_archivo_exp" class="col-sm-3 control-label">Archivo(*.pdf)</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_archivo" id="nombre_archivo" class="form-control text" value="<?php echo $expediente->archivo;?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="observacion" class="col-sm-3 control-label">Observaci&oacute;n del cuerpo</label>
				<div class="col-sm-5">
					<input type="textarea" name="observacion" id="observacion" class="form-control required text" value="<?php echo $expediente->observacion;?>"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Guardar</button> <button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
