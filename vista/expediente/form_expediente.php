<?php 
include("modelo/expediente.php");
$id_usuario_elapas=$_GET[id];
$fecha = date("Y-m-d H:i:s");
?>
<h2>Crear el Expediente</h2>
                      <br />
                      <div class="panel panel-default panel-shadow" data-collapsed="0">
                      	<div class="panel-heading">
    				  		<div class="panel-title">
    							Expediente
    				  		</div>
    				  	</div>
	<div class="panel-body">
		<form name="frm_expediente" id="frm_expediente" action="control/expediente/insertar_expediente.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<input type="hidden" name="id_usuario_elapas" id="id_usuario_elapas" value="<?php echo $id_usuario_elapas;?>">
			<div class="form-group">
			<label for="fecha_registro" class="col-sm-3 control-label">Fecha Registro</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_registro" id="fecha_resgistro" class="form-control required datepicker"  placeholder=''  value='<?php echo $fecha;?>' readonly/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_archivo" class="col-sm-3 control-label">Nombre archivo</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_archivo" id="nombre_archivo" class="form-control required text" value="DOCUMENTO INICIAL"/>
					<input type="hidden" name="id_usuario_ext" id="id_usuario_ext"value="<?php echo $id_usuario_ext; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label for="nro_fojas" class="col-sm-3 control-label">Numero de Fojas</label>
				<div class="col-sm-5">
					<input type="text" name="nro_fojas" id="nro_fojas" class="form-control required int"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre_archivo_exp" class="col-sm-3 control-label">Archivo(*.pdf)</label>
				<div class="col-sm-5">
					<input type="file" name="nombre_archivo" id="nombre_archivo" class="form-control required text"/>
				</div>
			</div>
			<div class="form-group">
				<label for="observacion" class="col-sm-3 control-label">Observaci&oacute;n del cuerpo</label>
				<div class="col-sm-5">
					<input type="textarea" name="observacion" id="observacion" class="form-control required text" value="NINGUNA"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
