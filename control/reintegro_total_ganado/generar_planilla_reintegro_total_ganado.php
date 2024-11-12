<?php
include("../../modelo/reintegro_total_ganado.php");
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$mes_reintegro = utf8_decode($_POST[mes]);
$gestion_reintegro = utf8_decode($_POST[gestion]);
$total_dias_reintegro = utf8_decode($_POST[total_dias]);

$reintegro_total_ganado = new reintegro_total_ganado();
$bd = new conexion();


$verificar = $bd->Consulta("select * from reintegro_total_ganado where mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
$verificar_1 = $bd->getFila($verificar);
if($verificar_1[gestion_reintegro]!=$gestion_reintegro && $verificar_1[mes_reintegro]!=$mes_reintegro)
{
	$registros_ac = $bd->Consulta("select * from total_ganado where mes=$mes_reintegro and gestion=$gestion_reintegro");
	while($registro_ac = $bd->getFila($registros_ac))
	{
		$haber_basico_reintegro = 0;
		$monto_horas_extra_reintegro = 0;
		$nro_horas_extra_reintegro = 0;
		$suplencia_reintegro = 0;

		$registros_ba = $bd->Consulta("select * from reintegro_bono_antiguedad rba inner join bono_antiguedad ba on rba.id_bono_antiguedad=ba.id_bono_antiguedad where rba.mes_reintegro=$mes_reintegro and rba.gestion_reintegro=$gestion_reintegro and ba.id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
		$registro_ba = $bd->getFila($registros_ba);
		
		$total_gan = $haber_basico_reintegro + $registro_ba[monto_reintegro] + $monto_horas_extra_reintegro + $suplencia_reintegro;

		$reintegro_total_ganado->registrar_reintegro_total_ganado($mes_reintegro, $gestion_reintegro, $registro_ac[total_dias], $registro_ac[haber_mensual], $haber_basico_reintegro, $registro_ba[monto_reintegro], $nro_horas_extra_reintegro, $monto_horas_extra_reintegro, $suplencia_reintegro, $total_gan, $registro_ac[id_total_ganado]);

	}

}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}

?>