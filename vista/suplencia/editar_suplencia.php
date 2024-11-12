
<?php

	include("modelo/suplencia.php");
	include("modelo/asignacion_cargo.php");
	include("modelo/trabajador.php");
    
    $id = security($_GET[id]);

    $suplencia = new suplencia();
    $asignacion_cargo = new asignacion_cargo();
    $trabajador = new trabajador();

    $suplencia->get_suplencia($id);
    $asignacion_cargo->get_asignacion_cargo($suplencia->id_asignacion_cargo);
    $trabajador->get_trabajador($asignacion_cargo->id_trabajador);
    $suplens = $bd->Consulta("select * from cargo");
?>

<h2>Editar suplencia</h2>
  <br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title">
Suplencia
</div>
</div>
<div class="panel-body">
<form name="frm_suplencia" id="frm_suplencia" action="control/suplencia/editar_suplencia.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
<input type="hidden" name="id_suplencia" id="id_suplencia" class="form-control required text" value='<?php echo $suplencia->id_suplencia; ?>'/>
<input type="hidden" name="id_asignacion_cargo" id="id_asignacion_cargo" class="form-control required text" value='<?php echo $suplencia->id_asignacion_cargo; ?>'/>
<div class="form-group">
<label for="gestion" class="col-sm-3 control-label">Gesti&oacute;n</label>
<div class="col-sm-5">
<input type="text" name="gestion" id="gestion" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($suplencia->gestion); ?>' readonly/>
</div>
</div>
<div class="form-group">
<label for="mes" class="col-sm-3 control-label">Mes</label>
<div class="col-sm-5">
<input type="text" name="mes" id="mes" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($suplencia->mes); ?>' readonly/>
</div>
</div>
<div class="form-group">
<label for="id_asignacion_cargo" class="col-sm-3 control-label">Trabajador</label>
<div class="col-sm-5">
<input type="text" name="trabajador" id="trabajador" class="form-control required text"  placeholder='' value='<?php echo utf8_encode($trabajador->apellido_paterno." ". $trabajador->apellido_materno." ".$trabajador->nombres); ?>' readonly/>
</div>
</div>
<div class="form-group">
<label for="fecha_inicio" class="col-sm-3 control-label">Fecha inicio</label>
<div class="col-sm-5">
<input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control required datepicker"  placeholder='' value='<?php echo utf8_encode($suplencia->fecha_inicio); ?>' readonly/>
</div>
</div>
<div class="form-group">
<label for="fecha_fin" class="col-sm-3 control-label">Fecha fin</label>
<div class="col-sm-5">
<input type="text" name="fecha_fin" id="fecha_fin" class="form-control required datepicker"  placeholder='' value='<?php echo utf8_encode($suplencia->fecha_fin); ?>' readonly/>
</div>
</div>
<div class="form-group">
<label for="total_dias" class="col-sm-3 control-label">Total d&iacute;as</label>
<div class="col-sm-5">
<input type="text" name="total_dias" id="total_dias" class="form-control required enteros"  placeholder='' value='<?php echo utf8_encode($suplencia->total_dias); ?>'/>
</div>
</div>
<div class="form-group">
<label for="id_cargo_suplencia" class="col-sm-3 control-label">Cargo Suplencia</label>
<div class="col-sm-5">
<select name="id_cargo_suplencia" id="id_cargo_suplencia" class="form-control required select2">

<?php
while($suple = $bd->getFila($suplens))
{
if($suplencia->cargo_suplencia == $suple[descripcion] && $suplencia->salario_mensual == $suple[salario_mensual])
{
	echo "<option value='$suple[id_cargo]' selected>".utf8_encode($suple[descripcion])."($suple[salario_mensual])</option>";
}
else
{
	echo "<option value='$suple[id_cargo]' >".utf8_encode($suple[descripcion])."($suple[salario_mensual])</option>";
}

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
