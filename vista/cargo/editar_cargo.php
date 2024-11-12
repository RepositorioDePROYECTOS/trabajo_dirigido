
<?php

	include("modelo/cargo.php");
    
    $id = security($_GET[id]);

    $cargo = new cargo();

    $cargo->get_cargo($id);

?>

<h2>Editar Cargo</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Cargo
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_cargo" id="frm_cargo" action="control/cargo/editar_cargo.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_cargo" id="id_cargo" class="form-control required text" value='<?php echo $cargo->id_cargo; ?>'/>
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Item</label>
				<div class="col-sm-5">
					<input type="text" name="item" id="item" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($cargo->item); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Nivel</label>
				<div class="col-sm-5">
					<input type="text" name="nivel" id="nivel" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($cargo->nivel); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="seccion" class="col-sm-3 control-label">Secci&oacute;n</label>
				<div class="col-sm-5">
					<select name="seccion" id="seccion" class="form-control required select">
						<?php
						$secciones = array('GERENCIA GENERAL', 'GERENCIA TECNICA', 'CATASTRO DE REDES', 'CAPTACION Y ADUCCION', 'PLANTA POTABILIZADORA DE AGUA', 'CONTROL DE CALIDAD', 'RED DE AGUA POTABLE', 'INSTALACION Y CONEXIONES', 'RED DE ALCANTARILLADO', 'PLANTA DE TRATAMIENTO Y AGUAS RESIDUALES', 'GERENCIA ADMINISTRATIVA Y FINANCIERA', 'GERENCIA COMERCIAL');
						for ($i=0; $i < 12; $i++) 
						{ 
							if($secciones[$i] == $cargo->seccion)
							{
								echo "<option value='$secciones[$i]' selected>$secciones[$i]</option>";
							}
							else
								echo  "<option value='$secciones[$i]'>$secciones[$i]</option>";
						}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
				<div class="col-sm-5">
					<input type="text" name="descripcion" id="descripcion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($cargo->descripcion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="salario_mensual" class="col-sm-3 control-label">Salario mensual</label>
				<div class="col-sm-5">
					<input type="text" name="salario_mensual" id="salario_mensual" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($cargo->salario_mensual); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado_cargo" class="col-sm-3 control-label">Estado cargo</label>
				<div class="col-sm-5">
					<select name="estado_cargo" id="estado_cargo" class="form-control required select">
						<?php
						if($cargo->estado_cargo == 'OCUPADO')
						{
							echo "<option value='OCUPADO' selected> OCUPADO</option><option value='LIBRE'> LIBRE</option>";
						}
						else
							if($cargo->estado_cargo == 'LIBRE')
							{
								echo "<option value='LIBRE'> LIBRE</option><option value='OCUPADO' selected> OCUPADO</option>";
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
