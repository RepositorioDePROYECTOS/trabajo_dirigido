
<?php

	include("modelo/eventual.php");
    
    $id = security($_GET[id]);

    $eventual = new eventual();

    $eventual->get_eventual($id);

?>

<h2>Editar Trabajador Eventual</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Trabajador
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_eventual" id="frm_eventual" action="control/eventual/editar_eventual.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_eventual" id="id_eventual" class="form-control required text" value='<?php echo $eventual->id_eventual; ?>'/>
			
			<div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-5">
					<input type="text" name="nombres" id="nombres" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->nombres); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellido_paterno" class="col-sm-3 control-label">Apellido Paterno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->apellido_paterno); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellido_materno" class="col-sm-3 control-label">Apellido Materno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_materno" id="apellido_materno" class="form-control text"  placeholder='' value='<?php echo utf8_encode($eventual->apellido_materno); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="item" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->item); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Nivel</label>
				<div class="col-sm-5">
					<input type="text" name="nivel" id="nivel" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->nivel); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Cargo</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->descripcion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="seccion" class="col-sm-3 control-label">Unidad de trabajo</label>
				<div class="col-sm-5">
					<input type="text" name="seccion" id="seccion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($eventual->seccion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="salario_mensual" class="col-sm-3 control-label">Salario mensual</label>
				<div class="col-sm-5">
					<input type="text" name="salario_mensual" id="salario_mensual" class="form-control required decimales"  placeholder='' value='<?php echo utf8_encode($eventual->salario_mensual); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_eventual" class="col-sm-3 control-label">Estado eventual</label>
				<div class="col-sm-5">
					<select name="estado_eventual" id="estado_eventual" class="form-control required select">
						<?php
						if($eventual->estado_eventual == 'HABILITADO')
						{
							echo "<option value='HABILITADO' selected> HABILITADO</option><option value='INHABILITADO'> INHABILITADO</option>";
						}
						else
						{
							echo "<option value='HABILITADO'> HABILITADO</option><option value='INHABILITADO' selected> INHABILITADO</option>";
						}
						?>
					</select>
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
