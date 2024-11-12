<?php
	$anio = date("Y-m-d");
?>
<h2>Lista de Salidas</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			Consultar rango de fechas
  		</div>
  	</div>

	<div class="panel-body">

		<form name="frm_salida" id="frm_salida" action="?mod=salida&lista" method="GET" role="form" class="form-horizontal form-groups-bordered">
			<input type="hidden" name="mod" value="salida"/>
            <input type="hidden" name="pag" value="lista"/>
			<div class="form-group">
				<label for="fecha" class="col-sm-2 control-label">Fecha inicio</label>
                <div class="col-sm-2">
				<input type="date" name="fecha_i" id="fecha_i" class="form-control required enteros" style="text-align: left;" required="" autocomplete="off" value="<?php echo $anio;?>" />
				</div>
				<label for="fecha" class="col-sm-2 control-label">Fecha final</label>
				<div class="col-sm-2">
					<input type="date" name="fecha_f" id="fecha_f" class="form-control required enteros" style="text-align: left;" required="" autocomplete="off" value="<?php echo $anio;?>" />
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-info">Mostrar</button>
				</div>
			</div>
		</form>

	</div>

</div>





