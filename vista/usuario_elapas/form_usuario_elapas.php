<?php
	include("modelo/expediente.php");
	include("modelo/caja.php");
    $registros = $bd->Consulta("select * from caja");
?>
<h2>Registro de Usuario</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nuevo Usuario
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_usuario_elapas" id="frm_usuario_externo" action="control/usuario_elapas/insertar_usuario_elapas.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
		<div class="form-group">
				<label for="nombre_usuario" class="col-sm-3 control-label">Nombre y Apellido</label>
				<div class="col-sm-5">
                    <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control required text" data-validate="required"  data-message-required="Escriba su nombre completo" placeholder='' auto_complete='off'/>
				</div>
			</div>
			<div class="form-group">
				<label for="nro_cuenta" class="col-sm-3 control-label">Nro. Cuenta</label>
				<div class="col-sm-5">
					<input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control required enteros" data-validate="required"  data-message-required="Escriba su nro_cuenta" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="codigo_catastral_actual" class="col-sm-3 control-label">Codigo Catastral Actual</label>
				<div class="col-sm-5">
					<input type="text" name="codigo_catastral_actual" id="codigo_catastral_actual" class="form-control required enteros" data-validate="required"  data-message-required="Escriba codigo catastral actual" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="codigo_catastral_antiguo" class="col-sm-3 control-label">Codigo Catastral Antiguo</label>
				<div class="col-sm-5">
					<input type="text" name="codigo_catastral_antiguo" id="codigo_catastral_antiguo" class="form-control required enteros" data-validate="required"  data-message-required="Escriba codigo catastral antiguo" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="documento" class="col-sm-3 control-label">Carnet de Identidad</label>
				<div class="col-sm-5">
					<input type="text" name="documento" id="documento" class="form-control required text" data-validate="required"  data-message-required="Escriba su CI" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direccion</label>
				<div class="col-sm-5">
					<input type="text" name="direccion" id="direccion" class="form-control required text" data-validate="required"  data-message-required="Escriba su Direccion de Domicilio" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="categoria" class="col-sm-3 control-label">Categoria</label>
				<div class="col-sm-5">
					<select name="categoria" id="categoria" class="form-control required">
						<option value="DOMESTICO" selected>DOMESTICO</option>
						<option value="COMERCIAL">COMERCIAL</option>
						<option value="ESTATAL">ESTATAL</option>
						<option value="SOCIAL">SOCIAL</option>
						<option value="INDUSTRIAL">INDUSTRIAL</option>
						<option value="EDIFICIOS Y CONDOMINIOS">EDIFICIOS Y CONDOMINIOS</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="paralelo" class="col-sm-3 control-label">Paralelo</label>
				<div class="col-sm-5">
					<select name="paralelo" id="paralelo" class="form-control required">
						<option value="No" selected>No</option>
						<option value="Si">Si</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="codigo_catastral_origen" class="col-sm-3 control-label">Codigo catastral origen</label>
				<div class="col-sm-5">
					<input type="text" name="codigo_catastral_origen" id="codigo_catastral_origen" class="form-control required enteros" data-validate="required"  data-message-required="Escriba su codigo catastral origen" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="numero_cuenta_origen" class="col-sm-3 control-label">Nro. cuenta origen</label>
				<div class="col-sm-5">
					<input type="text" name="numero_cuenta_origen" id="numero_cuenta_origen" class="form-control required enteros" data-validate="required"  data-message-required="Escriba su codigo catastral origen" placeholder=''/>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado del Usuario</label>
				<div class="col-sm-5">
					<select name="estado" id="estado" class="form-control required">
						<option value="HABILITADO" selected>HABILITADO</option>
						<option value="SUSPENDIDO">SUSPENDIDO</option>
					</select>
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
