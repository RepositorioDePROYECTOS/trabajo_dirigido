<?php
include("../../modelo/total_ganado.php");
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$total_dias = utf8_decode($_POST[total_dias]);

$total_ganado = new total_ganado();
$bd = new conexion();


$verificar = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion");
$verificar_1 = $bd->getFila($verificar);
if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
{
	$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join asistencia a on  ac.id_asignacion_cargo=a.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and mes=$mes and gestion=$gestion");
	while($registro_ac = $bd->getFila($registros_ac))
	{
		
		$haber_mensual = $registro_ac[salario];

		$haber_basico = ($haber_mensual/$registro_ac[dias_laborables]) * $registro_ac[dias_asistencia];

		$registros_ba = $bd->Consulta("select sum(monto) as monto_ba from bono_antiguedad where mes=$mes and gestion=$gestion and id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
		$registro_ba = $bd->getFila($registros_ba);

		$registros_he = $bd->Consulta("select sum(monto) as monto_he, sum(cantidad) as cant_hrs from horas_extra where mes=$mes and gestion=$gestion and id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
		$registro_he = $bd->getFila($registros_he);
		if( empty($registro_he[monto_he]))
		{
			$monto_he = 0;
			$nro_horas_extra = 0;
		}
		else
		{
			$monto_he = $registro_he[monto_he];
			$nro_horas_extra = $registro_he[cant_hrs];
		}

		$registros_s = $bd->Consulta("select sum(monto) as monto_s from suplencia where mes=$mes and gestion=$gestion and id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
		$registro_s = $bd->getFila($registros_s);
		if(empty($registro_s[monto_s]))
		{
			$monto_s = 0;
		}
		else
		{
			$monto_s = $registro_s[monto_s];
		}


		$total_gan = $haber_basico + $registro_ba[monto_ba] + $monto_he + $monto_s;

		$total_ganado->registrar_total_ganado($mes, $gestion, $registro_ac[dias_asistencia], $haber_mensual, $haber_basico, $registro_ba[monto_ba], $nro_horas_extra, $monto_he, $monto_s, $total_gan, $registro_ac[id_asignacion_cargo]);

	}

}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}

?>