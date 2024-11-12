<h2>Crear salida</h2>
<?php
date_default_timezone_set('America/La_Paz');
session_start();
$mes = date("m");
$tiempo = date("H:i");
include("modelo/salida.php");
$registros = $bd->Consulta("select * from salida");
$registros_t = $bd->Consulta("SELECT * FROM usuario u inner join rol r on r.id_rol=u.id_rol inner join trabajador t on t.id_trabajador=u.id_trabajador inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador inner join cargo c on ac.id_cargo=c.id_cargo where u.id_usuario=$_SESSION[id_usuario]");
$registro_t = $bd->getFila($registros_t);

$nombre_completo = utf8_encode($registro_t[nombres])." ".utf8_encode($registro_t[apellido_paterno])." ".utf8_encode($registro_t[apellido_materno]);

$r_chofer = $bd->Consulta("select * from trabajador where estado_trabajador='HABILITADO'");
$r_salida = $bd->Consulta("select * from tipo_salida");
$registro_tipo_salida = $bd->Consulta("select * from tipo_salida");
$registro_vehiculo = $bd->Consulta("select * from vehiculo");
$horas_soli = $bd->Consulta("SELECT * FROM salida s INNER JOIN vehiculo v ON v.id_vehiculo = s.id_vehiculo INNER JOIN usuario u ON u.id_usuario = s.id_usuario INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida INNER JOIN trabajador t ON u.id_trabajador = t.id_trabajador WHERE s.estado =2 AND u.id_usuario =$_SESSION[id_usuario] AND ts.nombre = 'PARTICULAR' AND MONTH( s.fecha ) =$mes");
$n=0;
while($registro_hor = $bd->getFila($horas_soli)) 
{
    $datos_hora[$n++]=$registro_hor[tiempo_solicitado];
}
$horas_total=sumar_horas($datos_hora);
?>
<br>
<div class="panel panel-default panel-shadow" data-collapsed="0">
  	<div class="panel-heading">
  		<div class="panel-title">
			PAPELETA DE SALIDA <? echo $datos_hora;?>
  		</div>
  	</div>
	<div class="panel-body">
		<form name="frm_salida" id="frm_salida" action="control/salida/insertar_salida.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
			<div class="form-group">
				<div class="col-sm-11">
					<label for="nom_funcionario" class="col-sm-2 control-label">Nombre y Apellido del Funcionario</label>
					<div class="col-sm-8">
						<input type="text" name="nom_funcionario" id="nom_funcionario" class="form-control required text" data-validate="required" readonly value="<?php echo $nombre_completo;?>"/>
						<input type="hidden" name="id_usuario" id="id_usuario" readonly value="<?php echo $registro_t[id_usuario];?>"/>
						<input type="hidden" name="horas_total" id="horas_total" value="<?php echo $horas_total;?>"/>
					</div>
				</div>
			</div>
			<!--  DATOS DE ORDENANZA -->
			<div class="form-group">
					<div class="col-sm-11">
						<label for="cargo" class="col-sm-1 control-label">Cargo</label>
						<div class="col-sm-3">
							<input type="text" name="cargo" id="cargo" class="form-control required text" data-validate="required" readonly value="<?php echo $registro_t[cargo];?>"/>
						</div>
						<label for="area" class="col-sm-1 control-label">Gerencia de Area</label>
						<div class="col-sm-3">
							<input type="text" name="seccion" id="seccion" class="form-control required text" data-validate="required" readonly value="<?php echo $registro_t[seccion];?>"/>
						</div>
						<label for="cargo2" class="col-sm-1 control-label">Jefatura</label>
						<div class="col-sm-2">
							<input type="text" name="cargo2" id="cargo2" class="form-control required text" data-validate="required" readonly value="<?php echo $registro_t[seccion];?>"/>
						</div>
					</div>
			</div>
			<!--  DATOS DE ORDENANZA -->
			<div class="form-group">
				<div class="col-sm-12">
					<label for="tipo_salida" class="col-sm-1 control-label">Salida</label>
						<?php
						$t=0;
						echo '<div class="row">';
						while($t_salida = $bd->getFila($r_salida))
						{	
							$t++;
							echo "<div class='col-sm-2'>";
							echo "<input type='radio' id='tipo_salida".$t."' class='col-sm-3 form-control-radio' name='tipo_salida' value='$t_salida[id_tipo_salida]' onchange='javascript:showObs()'>";
							echo "<label for='tipo_salida".$t."' class='col control-label'>$t_salida[nombre]</label>";
							echo "</div>";
						}
						echo '</div>';
						?>
				</div>
			</div>	
			<div class="form-group" id="vehiculo" style="display: none;">
				<div class="col-sm-11">
					<label for="id_conductor" class="col-sm-2 control-label">Nombre del Conductor</label>
					<div class="col-sm-4">
						<select name="id_conductor" id="id_conductor" class="form-control required select2">
							<option value="0" selected>--SELECCIONE--</option>
							<?php
								while($conductor = $bd->getFila($r_chofer))
								{
									echo "<option value='$conductor[id_trabajador]'>$conductor[nombres] $conductor[apellido_paterno] $conductor[apellido_materno]</option>";
								}
							?>
							
						</select>
					</div>
					<label for="id_vehiculo" class="col-sm-1 control-label">Auto</label>
					<div class="col-sm-3">
						<select name="id_vehiculo" id="id_vehiculo" class="form-control required select2">
							<option value="1" selected>--SELECCIONE--</option>
							<?php
								while($r_vehiculo = $bd->getFila($registro_vehiculo))
								{
									echo "<option value='$r_vehiculo[id_vehiculo]'>$r_vehiculo[modelo] : $r_vehiculo[marca]</option>";
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-7">
					<label for="fecha" class="col-sm-3 control-label">Fecha</label>
					<div class="col-sm-3">
						<input type="date" name="fecha" id="fecha" class="form-control required text" data-validate="required" value="<?php echo date("Y-m-d");?>" placeholder=''/>
					</div>
					
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-11">
					<label for="hora_desde" class="col-sm-2 control-label">Hora Salida</label>
					<div class="col-sm-2">
						<!-- <input id="hora_desde" type="text" name="hora_desde" value="8:30"> -->
						<input type="time" id="hora_desde" name="hora_desde" value="<?php echo $tiempo; ?>" class="form-control" onchange="calculardif()" />
					</div>
					<div id="hora_h">
						<label for="hora_hasta" class="col-sm-1 control-label">Hora Retorno</label>
						<div class="col-sm-2">
							<input type="time" id="hora_hasta" name="hora_hasta" value="<?php echo $tiempo; ?>" class="form-control" onchange="calculardif()" />
							<!-- <input id="hora_hasta" type="text" name="hora_hasta" value="10:30"> -->
						</div>
					</div>
					<label for="horas_justificacion_real" class="col-sm-1 control-label">Tiempo de salida</label>
					<div class="col-sm-2">
						<!-- <input type="text" id="horas_justificacion_real" readonly /> -->
						<input type="text" name="horas_justificacion_real" id="horas_justificacion_real" class="form-control"  readonly/>
					</div>
				</div>
			</div>
			<br>
			<div id="detalle_salida">
				<div class="form-group">
					<div class="col-sm-11">
						<label for="direccion_salida" class="col-sm-2 control-label">Direccion de salida</label>
						<div class="col-sm-8">
							<input type="text" name="direccion_salida" id="direccion_salida" class="form-control text"  autocomplete="off"  placeholder=''/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-11">
						<label for="motivo" class="col-sm-2 control-label">Motivo de la Salida</label>
						<div class="col-sm-8">
							<input type="text" name="motivo" id="motivo" class="form-control text" autocomplete="off"  placeholder=''/>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group" id="obs" style="display: none;">
				<div class="col-sm-11" >
					<label for="observaciones" class="col-sm-2 control-label">Observaciones</label>
					<div class="col-sm-8">
						<textarea id="observaciones" name="observaciones" rows="4" cols="30" value="-" class="form-control text" >-</textarea>
					</div>
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
