<?php
include("../../modelo/fondo_empleados.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$porcentaje_fe = utf8_decode($_POST[porcentaje_fe]);

$fondo_empleados = new fondo_empleados();
$bd = new conexion();

$verificar = $bd->Consulta("select * from fondo_empleados where mes=$mes and gestion=$gestion");
$verificar_1 = $bd->getFila($verificar);
if(empty($verificar_1))
{
	$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join total_ganado tg on tg.id_asignacion_cargo=ac.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and ac.socio_fe=1 and mes=$mes and gestion=$gestion");


	while($registro_ac = $bd->getFila($registros_ac))
	{
		
		$monto_fe = round(($registro_ac[total_ganado]*$porcentaje_fe)/100,2);
		$pago_deuda = 0;
		$total_fe = $monto_fe + $pago_deuda;
		$fondo_empleados->registrar_fondo_empleados($mes, $gestion, $porcentaje_fe, $registro_ac[total_ganado], $monto_fe, $pago_deuda, $total_fe, $registro_ac[id_asignacion_cargo]);
	}
}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}





?>