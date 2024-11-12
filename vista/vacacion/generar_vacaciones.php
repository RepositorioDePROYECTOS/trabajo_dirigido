<h2>Actulizar Vacaciones seg&uacute;n fecha de calculo</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
	<div class="panel-heading">
		<div class="panel-title">
		Vacaciones
		</div>
	</div>
	<div class="panel-body">
		<form name="frm_generar_vacaciones" id="frm_generar_vacaciones" action="control/vacacion/generar_vacaciones.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">

			<div class="form-group">
				<label for="fecha_calculo" class="col-sm-3 control-label">Fecha calculo</label>
				<div class="col-sm-5">
					<input type="text" name="fecha_calculo" id="fecha_calculo" class="form-control required datepicker" readonly />
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-5">
					<button type="submit" class="btn btn-info">Generar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>
