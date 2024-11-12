<?php
include("../../modelo/reintegro_aporte_laboral.php");
include("../../modelo/funciones.php");

referer_permit();

$mes_reintegro = utf8_decode($_POST[mes]);
$gestion_reintegro = utf8_decode($_POST[gestion]);
$fecha_calculo = utf8_decode($_POST[fecha_calculo]);

$reintegro_aporte_laboral = new reintegro_aporte_laboral();
$bd = new conexion();

$verificar_pls = $bd->Consulta("select * from reintegro_total_ganado where mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{
	$verificar = $bd->Consulta("select * from reintegro_aporte_laboral where mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion_reintegro]!=$gestion_reintegro && $verificar_1[mes_reintegro]!=$mes_reintegro)
	{
		$registros_ac = $bd->Consulta("select * from total_ganado  tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where tg.gestion=$gestion_reintegro and tg.mes=$mes_reintegro");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$registros_tg = $bd->Consulta("select * from reintegro_total_ganado where id_total_ganado=$registro_ac[id_total_ganado] and mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
			$registro_tg = $bd->getFila($registros_tg);

			$total_ganado_reintegro = $registro_tg[total_ganado_reintegro];

			$registros_apo = $bd->Consulta("select * from conf_aportes where estado='HABILITADO'");
			while($registro_apo = $bd->getFila($registros_apo))
			{
				if ($total_ganado_reintegro > 0)
				{
					if($registro_apo[rango_inicial] >= 13000)
					{
						if($total_ganado_reintegro >= $registro_apo[rango_inicial] && $total_ganado_reintegro <= $registro_apo[rango_final])
						{
							if($registro_apo[tipo_aporte]=='COTIZACION MENSUAL' && $registro_ac[aportante_afp]==0)
							{
								$monto_aporte_reintegro = 0;
								$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
							}
							else
							{
								$monto_aporte_reintegro = (($total_ganado_reintegro - $registro_apo[rango_inicial])*$registro_apo[porc_aporte])/100;
								$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
							}
						}
						else
						{
							$monto_aporte_reintegro = 0;
							$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
						}	
					}
					else
					{	
						if($total_ganado_reintegro >= $registro_apo[rango_inicial] && $total_ganado_reintegro <= $registro_apo[rango_final])
						{
							$anios = calculaedad($fecha_calculo, $registro_ac[fecha_nacimiento]);
							if($anios >=65 && $registro_apo[tipo_aporte] == 'PRIMA RIESGO COMUN')
							{
								$monto_aporte_reintegro = 0;
								$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
							}
							else
							{
								if($registro_apo[tipo_aporte]=='COTIZACION MENSUAL' && $registro_ac[aportante_afp]==0)
								{
									$monto_aporte_reintegro = 0;
									$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
								}
								else
								{
									$monto_aporte_reintegro = ($total_ganado_reintegro*$registro_apo[porc_aporte])/100;
									$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
								}
								
							}
						}
					}
				}
				else
				{
					$monto_aporte_reintegro = 0;
					$reintegro_aporte_laboral->registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte_reintegro, $registro_tg[id_total_ganado_reintegro]);
				}		
				
			}
		}

	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}
}
else
echo "Error. tiene que generar las planillas de total ganado... antes de generar planilla de aporte laboral";
?>