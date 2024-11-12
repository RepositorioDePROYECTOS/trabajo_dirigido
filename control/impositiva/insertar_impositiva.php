<?php
include("../../modelo/impositiva.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);



$impositiva = new impositiva();
$bd = new conexion();

$ufvs = $bd->Consulta("select max(id_impositiva), ufv_actual, ufv_pasado from impositiva where mes=$mes and gestion=$gestion");
$ufv = $bd->getFila($ufvs);
$ufv_actual = $ufv[ufv_actual];
$ufv_pasado = $ufv[ufv_pasado];

$verificar_pls = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join aporte_laboral al on al.id_asignacion_cargo=ac.id_asignacion_cargo where tg.mes=$mes and tg.gestion=$gestion and tg.id_asignacion_cargo=$id_asignacion_cargo");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{
	$verificar = $bd->Consulta("select * from impositiva where mes=$mes and gestion=$gestion and id_asignacion_cargo=$id_asignacion_cargo");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes && $verificar_1[id_asignacion_cargo]!=$id_asignacion_cargo)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO' and id_asignacion_cargo=$id_asignacion_cargo");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$tls_ganado = $bd->Consulta("select * from total_ganado where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$tl_ganado = $bd->getFila($tls_ganado);
			$total_ganado = $tl_ganado[total_ganado];
			if($mes == 1)
			{
				$mes_anterior = 12;
				$anio_anterior = $gestion -1;
			}
			else
			{
				$mes_anterior = $mes-1;
				$anio_anterior = $gestion;
			}

			$registros_r = $bd->Consulta("select * from refrigerio where mes=$mes and gestion=$gestion and id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
			$registro_r = $bd->getFila($registros_r);

			$registros_ma = $bd->Consulta("select * from impositiva where mes=$mes_anterior and gestion=$anio_anterior and id_asignacion_cargo=$registro_ac[id_asignacion_cargo]");
			$registro_ma = $bd->getFila($registros_ma);

			$registros_apo = $bd->Consulta("select sum(monto_aporte) as aporte_total from aporte_laboral where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_apo = $bd->getFila($registros_apo);
			$aportes_laborales = $registro_apo[aporte_total];
			$refrigerio = $registro_r[total_refrigerio];
			$sueldo_neto = ($total_ganado - $aportes_laborales) + $refrigerio;
			$registros_imp = $bd->Consulta("select * from conf_impositiva where estado='HABILITADO'");
			$registro_imp = $bd->getFila($registros_imp);
			$minimo_no_imponible = $registro_imp[salario_minimo] * $registro_imp[cant_sm];

			if($sueldo_neto > $minimo_no_imponible)
			{
				$base_imponible = $sueldo_neto - $minimo_no_imponible;
			}	
			else
			{
				$base_imponible = 0;
			}

			$impuesto_bi = ($base_imponible * $registro_imp[porcentaje_imp])/100;

			$presentacion_desc = 0;

			$impuesto_mn = ($minimo_no_imponible*$registro_imp[porcentaje_imp])/100;

			if($impuesto_bi <= $impuesto_mn)
			{
				$impuesto_bi = 0;
				$impuesto_mn = 0;
			}

			$saldo_dependiente = $presentacion_desc + $impuesto_mn;
			
			$saldo_fisco = $impuesto_bi;

			$saldo_mes_anterior = $registro_ma[saldo_siguiente_mes];
			$actualizacion = ($saldo_mes_anterior*$ufv_actual/$ufv_pasado)-$saldo_mes_anterior;
			$saldo_total_mes_anterior = $saldo_mes_anterior + $actualizacion;
			$saldo_total_dependiente = $saldo_dependiente + $saldo_total_mes_anterior;
			$saldo_utilizado = $saldo_fisco;
			if($saldo_total_dependiente >= $saldo_fisco)
			{
				$retencion_pagar = 0;
			}
			else
			{
				$retencion_pagar = $saldo_fisco - $saldo_total_dependiente;
			}
			if($saldo_total_dependiente > $saldo_fisco)
			{
				$saldo_siguiente_mes = $saldo_total_dependiente - $saldo_fisco;
			}
			else
			{
				$saldo_siguiente_mes = 0;
			}


			$impositiva->registrar_impositiva($mes, $gestion, $ufv_actual, $ufv_pasado, $total_ganado, $aportes_laborales, $sueldo_neto, $minimo_no_imponible, $base_imponible, $impuesto_bi, $presentacion_desc, $impuesto_mn, $saldo_dependiente, $saldo_fisco, $saldo_mes_anterior, $actualizacion, $saldo_total_mes_anterior, $saldo_total_dependiente, $saldo_utilizado, round($retencion_pagar,0), $saldo_siguiente_mes, $registro_ac[id_asignacion_cargo]);
		}

	}
	else
	{
		echo "Error. Ya se tiene generada impositiva para ese periodo";
	}
}
else
echo "Error. tiene que generar las planillas de total ganado y aportes laborales primero";
?>