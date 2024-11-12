<?php
	$anio = date("Y");
?>
<h2>Lista de usuarios ELAPAS</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Consultar
  		</div>
  	</div>

	<div class="panel-body">

		<form name="frm_consulta" id="frm_consulta" action="?mod=usuario_elapas&lista" method="GET" role="form" class="form-horizontal form-groups-bordered">
			<input type="hidden" name="mod" value="usuario_elapas"/>
            <input type="hidden" name="pag" value="lista"/>
			<div class="form-group">
				<label for="fecha" class="col-sm-2 control-label">Codigo Usuario</label>
                <div class="col-sm-2">
				<input type="text" name="codigo_catastral" id="codigo_catastral" class="form-control required enteros" style="text-align: left;" required="" value="0" autocomplete="off"/>
				</div>
				<label for="fecha" class="col-sm-2 control-label">Nro Cuenta</label>
				<div class="col-sm-2">
					<input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control required enteros" style="text-align: left;" required="" value="0" autocomplete="off"/>
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-info">Mostrar</button>
				</div>
			</div>
		</form>

	</div>

</div>





