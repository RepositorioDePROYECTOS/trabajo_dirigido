<?php
include("../../modelo/fondo_empleados.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$porcentaje_fe = utf8_decode($_POST[porcentaje_fe]);
$pago_deuda = utf8_decode($_POST[pago_deuda]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$fondo_empleados = new fondo_empleados();
$bd = new conexion();

$verificar = $bd->Consulta("select * from fondo_empleados where mes=$mes and gestion=$gestion and id_asignacion_cargo=$id_asignacion_cargo");
$verificar_1 = $bd->getFila($verificar);
if(empty($verificar_1))
{
	$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join total_ganado tg on tg.id_asignacion_cargo=ac.id_asignacion_cargo where ac.id_asignacion_cargo=$id_asignacion_cargo and ac.estado_asignacion='HABILITADO' and ac.socio_fe=1 and tg.mes=$mes and tg.gestion=$gestion");


	while($registro_ac = $bd->getFila($registros_ac))
	{
		
		$monto_fe = round(($registro_ac[total_ganado]*$porcentaje_fe)/100,2);
		$total_fe = $monto_fe + $pago_deuda;
		$fondo_empleados->registrar_fondo_empleados($mes, $gestion, $porcentaje_fe, $registro_ac[total_ganado], $monto_fe, $pago_deuda, $total_fe, $registro_ac[id_asignacion_cargo]);
	}
}
else
{
	echo "Error. Ya se tiene generada el fondo de empleado de ese periodo";
}

?>