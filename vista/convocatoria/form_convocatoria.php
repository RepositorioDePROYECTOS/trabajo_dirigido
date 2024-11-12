<?php
	include("modelo/convocatoria.php");
?>
<h2>Crear Convocatoria</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Nueva Convocatoria
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_convocatoria" id="frm_convocatoria" action="control/convocatoria/insertar_convocatoria.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			
			<!-- Nombre de la Convocatoria -->
			<div class="form-group">
				<label for="nombre_convocatoria" class="col-sm-3 control-label">Nombre de la Convocatoria</label>
				<div class="col-sm-5">
					<input type="text" name="nombre_convocatoria" id="nombre_convocatoria" class="form-control required text" data-validate="required" data-message-required="Escriba el nombre de la convocatoria" placeholder=""/>
				</div>
			</div>
			
			<!-- Fecha de Inicio -->
			<div class="form-group">
				<label for="Fecha_inicio" class="col-sm-3 control-label">Fecha de Inicio</label>
				<div class="col-sm-5">
					<input type="date" name="Fecha_inicio" id="Fecha_inicio" class="form-control required text" data-validate="required" data-message-required="Seleccione la fecha de inicio"/>
				</div>
			</div>
			
			<!-- Fecha de Fin -->
			<div class="form-group">
				<label for="Fecha_fin" class="col-sm-3 control-label">Fecha de Fin</label>
				<div class="col-sm-5">
					<input type="date" name="Fecha_fin" id="Fecha_fin" class="form-control required text" data-validate="required" data-message-required="Seleccione la fecha de fin"/>
				</div>
			</div>
			
			<!-- Estado -->
			<div class="form-group">
				<label for="Estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-5">
					<select name="Estado" id="Estado" class="form-control required select2">
						<option value="1">Habilitado</option>
						<option value="2">Deshabilitado</option>
						<option value="3">Indefinido</option>
					</select>
				</div>
			</div>
			
			<!-- Vacantes -->
			<div class="form-group">
				<label for="Vacantes" class="col-sm-3 control-label">Vacantes</label>
				<div class="col-sm-5">
					<input type="number" name="Vacantes" id="Vacantes" class="form-control required text" data-validate="required" data-message-required="Escriba el número de vacantes" placeholder=""/>
				</div>
			</div>
			
			<!-- Requisitos -->
			<div class="form-group">
				<label for="Requisitos" class="col-sm-3 control-label">Requisitos</label>
				<div class="col-sm-5">
					<textarea name="Requisitos" id="Requisitos" class="form-control required text" rows="4" data-validate="required" data-message-required="Escriba los requisitos de la convocatoria" placeholder=""></textarea>
				</div>
			</div>
			<!-- JavaScript para eliminar o cambiar en un futuro a un archivo -->
            <script>
                document.getElementById('Requisitos').addEventListener('keyup', function(event) {
                    if (event.keyCode === 13) {
                        let textarea = this;
                        let text = textarea.value;
                        
                        let lines = text.split('\n');
                        
                        for (let i = 0; i < lines.length; i++) {
                            lines[i] = lines[i].startsWith('▶') ? lines[i] : '▶ ' + lines[i].trim();
                        }
                        
                        textarea.value = lines.join('\n');
                    }
                });
            </script>
			
			<!-- Botones -->
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Registrar</button> 
					<button type="button" class="btn cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
