<?php
include("../../modelo/reintegro_planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);

$reintegro_planilla = new reintegro_planilla();
$bd = new conexion();

$verificar_pls = $bd->Consulta("select * from reintegro_aporte_laboral where mes_reintegro=$mes and gestion_reintegro=$gestion");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{

	$verificar = $bd->Consulta("select * from reintegro_planilla where mes_reintegro=$mes and gestion_reintegro=$gestion");
	$verificar_1 = $bd->getFila($verificar);
	if(empty($verificar_1))
	{
		$registros_ac = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where tg.gestion=$gestion and tg.mes=$mes");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$registros_tg = $bd->Consulta("select * from reintegro_total_ganado rtg inner join total_ganado tg on rtg.id_total_ganado=tg.id_total_ganado where tg.id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and rtg.mes_reintegro=$mes and rtg.gestion_reintegro=$gestion and tg.mes=$mes and tg.gestion=$gestion");
			$registro_tg = $bd->getFila($registros_tg);
			$registros_apo = $bd->Consulta("select * from reintegro_aporte_laboral ral inner join reintegro_total_ganado rtg on ral.id_total_ganado_reintegro=rtg.id_total_ganado_reintegro inner join total_ganado tg on tg.id_total_ganado=rtg.id_total_ganado where tg.id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and ral.mes_reintegro=$mes and ral.gestion_reintegro=$gestion");
			$suma = 0;
			while($registro_apo = $bd->getFila($registros_apo))
			{
				if($registro_apo[tipo_aporte_reintegro] == 'COTIZACION MENSUAL')
				{
					$categoria_individual_reintegro = $registro_apo[monto_aporte_reintegro];
				}
				else
					if($registro_apo[tipo_aporte_reintegro] == 'PRIMA RIESGO COMUN')
					{
						$prima_riesgo_comun_reintegro = $registro_apo[monto_aporte_reintegro];
					}
					else
						if($registro_apo[tipo_aporte_reintegro] == 'COMISION AL ENTE ADMINISTRADOR')
						{
							$comision_ente_reintegro = $registro_apo[monto_aporte_reintegro];
						}
						else
						{
							$suma = $registro_apo[monto_aporte_reintegro] + $suma;
						}
			}

			$fondo_social_reintegro= 0;				
			$otros_descuentos_reintegro = 0;
			$fondo_empleados_reintegro = 0;

			$registros_imp = $bd->Consulta("select * from impositiva where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_imp = $bd->getFila($registros_imp);

			$total_aporte_solidario_reintegro = $suma;

			$item_reintegro = $registro_ac[item];
			$ci_reintegro = $registro_ac[ci];
			$nombres_reintegro = $registro_ac[nombres];
			$apellidos_reintegro = $registro_ac[apellido_paterno]." ".$registro_ac[apellido_materno];
			$cargo_reintegro = $registro_ac[cargo];
			$fecha_ingreso_reintegro = $registro_ac[fecha_ingreso];
			$dias_pagado_reintegro = $registro_tg[total_dias_reintegro];
			$haber_mensual_reintegro = $registro_tg[haber_mensual_reintegro];
			$haber_basico_reintegro = $registro_tg[haber_basico_reintegro];
			$bono_antiguedad_reintegro = $registro_tg[bono_antiguedad_reintegro];
			$horas_extra_reintegro = $registro_tg[monto_horas_extra_reintegro];
			$suplencia_reintegro = $registro_tg[suplencia_reintegro];
			$total_ganado_reintegro = $registro_tg[total_ganado_reintegro];
			$sindicato_reintegro = 0;
			$desc_rciva_reintegro = 0;

			$total_descuentos_reintegro = $sindicato_reintegro + $categoria_individual_reintegro + $prima_riesgo_comun_reintegro + $comision_ente_reintegro + $total_aporte_solidario_reintegro + $desc_rciva_reintegro + $otros_descuentos_reintegro + $fondo_social + $fondo_empleados_reintegro + $entidades_financieras_reintegro;
			$liquido_pagable_reintegro = $total_ganado_reintegro - $total_descuentos_reintegro;
			$estado_planilla_reintegro = 'GENERADO';
			$fecha_generado_reintegro = date('Y-m-d');
			$nua_reintegro = $registro_ac[nua];
			

			$registros_p = $bd->Consulta("select * from planilla where item=$registro_ac[item] and gestion=$gestion and mes=$mes");
			$registro_p = $bd->getFila($registros_p);
			$id_planilla = $registro_p[id_planilla];

			$reintegro_planilla->registrar_reintegro_planilla($mes, $gestion, $item_reintegro, $ci_reintegro, $nua_reintegro, $nombres_reintegro, $apellidos_reintegro, $cargo_reintegro, $fecha_ingreso_reintegro, $dias_pagado_reintegro, $haber_mensual_reintegro, $haber_basico_reintegro, $bono_antiguedad_reintegro, $horas_extra_reintegro, $suplencia_reintegro, $total_ganado_reintegro, $sindicato_reintegro, $categoria_individual_reintegro, $prima_riesgo_comun_reintegro, $comision_ente_reintegro, $total_aporte_solidario_reintegro, $desc_rciva_reintegro, $otros_descuentos_reintegro, $fondo_social_reintegro, $fondo_empleados_reintegro, $entidades_financieras_reintegro, $total_descuentos_reintegro, $liquido_pagable_reintegro, $estado_planilla_reintegro, $fecha_generado_reintegro, $id_planilla);
		}

	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}
}
else
echo "Error. tiene que generar todas las planillas previas del mes primero";
?>