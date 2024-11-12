
<?php

	include("modelo/trabajador.php");
    
    $id = security($_GET[id]);

    $trabajador = new trabajador();

    $trabajador->get_trabajador($id);

?>

<h2>Editar Trabajador</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Trabajador
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_trabajador" id="frm_trabajador" action="control/trabajador/editar_trabajador.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
					<input type="hidden" name="id_trabajador" id="id_trabajador" class="form-control required text" value='<?php echo $trabajador->id_trabajador; ?>'/>
			<div class="form-group">
				<label for="ci" class="col-sm-3 control-label">CI</label>
				<div class="col-sm-5">
					<input type="text" name="ci" id="ci" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->ci); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="exp" class="col-sm-3 control-label">Expedido</label>
				<div class="col-sm-5">
					<select name="exp" id="exp" class="form-control required select">
						<?php
							$departamento = array("CHUQUISACA","POTOSI","ORURO","LA PAZ","COCHABAMBA","TARIJA","SANTA CRUZ","BENI","PANDO");
							for ($i=0; $i < 9; $i++) 
							{ 
								if($trabajador->exp == $departamento[$i])
								{
									echo "<option value='$departamento[$i]' selected>$departamento[$i]</option>";
								}
								else
								{
									echo "<option value='$departamento[$i]'>$departamento[$i]</option>";
								}
							}
						?>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nua" class="col-sm-3 control-label">NUA</label>
				<div class="col-sm-5">
					<input type="text" name="nua" id="nua" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->nua); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-5">
					<input type="text" name="nombres" id="nombres" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->nombres); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellido_paterno" class="col-sm-3 control-label">Apellido Paterno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="apellido_materno" class="col-sm-3 control-label">Apellido Materno</label>
				<div class="col-sm-5">
					<input type="text" name="apellido_materno" id="apellido_materno" class="form-control text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_materno); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->direccion); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="sexo" class="col-sm-3 control-label">Sexo</label>
				<div class="col-sm-5">
					<select name="sexo" id="sexo" class="form-control required select">
					<?php
					if($trabajador->sexo == 'F')
					{
						echo "<option value='F' selected> FEMENINO</option><option value='M'> MASCULINO</option>";
					}
					else
					{
						echo "<option value='F'> FEMENINO</option><option value='M' selected> MASCULINO</option>";
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="nacionalidad" class="col-sm-3 control-label">Nacionalidad</label>
				<div class="col-sm-5">
					<input type="text" name="nacionalidad" id="nacionalidad" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->nacionalidad); ?>'/>
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_nacimiento" class="col-sm-3 control-label">Fecha nacimiento</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control required datepicker"  placeholder='' value='<?php echo utf8_encode($trabajador->fecha_nacimiento); ?>' readonly/>
				</div>
			</div>

			<div class="form-group">
				<label for="grado_formacion" class="col-sm-3 control-label">Grado de Formaci&oacute;n</label>
				<div class="col-sm-5">
					<select name="grado_formacion" id="grado_formacion" class="form-control required select">
						<option value='NO EXISTE INFORMACION' selected>NO EXISTE INFORMACION</option>
						<option value='DOCTORADO'>DOCTORADO</option>
						<option value='MAESTRIA'>MAESTRIA</option>
						<option value='LICENCIATURA'>LICENCIATURA</option>
						<option value='BACHILLER'>BACHILLER</option>
						<option value='EGRESADO'>EGRESADO</option>
						<option value='TECNICO SUPERIOR'>TECNICO SUPERIOR</option>
						<option value='UNIVERSITARIO'>UNIVERSITARIO</option>
						<option value='TECNICO MEDIO'>TECNICO MEDIO</option>
						<option value='SECUNDARIA'>SECUNDARIA</option>
						<option value='PRIMARIA'>PRIMARIA</option>
						<option value='NORMALISTA'>NORMALISTA</option>
						<option value='EGRESADO NORMALISTA'>EGRESADO NORMALISTA</option>
						<option value='DECLARADO TITULAR POR ANTIGUEDAD'>DECLARADO TITULAR POR ANTIGUEDAD</option>
						<option value='EXTRANJERO O NAL. REVAL NORMAL'>EXTRANJERO O NAL. REVAL NORMAL</option>
						<option value='EGRESADO TECNICO MEDIO'>EGRESADO TECNICO MEDIO</option>
						<option value='EGRESADO TECNICO SUPERIOR'>EGRESADO TECNICO SUPERIOR</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="titulo_academico" class="col-sm-3 control-label">T&iacute;tulo Academico</label>
				<div class="col-sm-5">
					<input type="text" name="titulo_academico" id="titulo_academico" class="form-control required" value="SIN INFORMACION" />
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_anios" class="col-sm-3 control-label">A&ntilde;os antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_anios" id="antiguedad_anios" class="form-control required enteros" value="<?php echo utf8_encode($trabajador->antiguedad_anios); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_meses" class="col-sm-3 control-label">Meses antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_meses" id="antiguedad_meses" class="form-control required enteros" value="<?php echo utf8_encode($trabajador->antiguedad_meses); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="antiguedad_dias" class="col-sm-3 control-label">D&iacute;as antiguedad</label>
				<div class="col-sm-5">
					<input type="text" name="antiguedad_dias" id="antiguedad_dias" class="form-control required enteros" value="<?php echo utf8_encode($trabajador->antiguedad_dias); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="estado_trabajador" class="col-sm-3 control-label">Estado trabajador</label>
				<div class="col-sm-5">
					<select name="estado_trabajador" id="estado_trabajador" class="form-control required select">
						<?php
						if($trabajador->estado_trabajador == 'HABILITADO')
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
