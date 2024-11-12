<?php
include("../../modelo/aporte_laboral.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$fecha_calculo = utf8_decode($_POST[fecha_calculo]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$aporte_laboral = new aporte_laboral();
$bd = new conexion();

$verificar_pls = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion and id_asignacion_cargo=$id_asignacion_cargo");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{
	$verificar = $bd->Consulta("select * from aporte_laboral where mes=$mes and gestion=$gestion and id_asignacion_cargo=$id_asignacion_cargo");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes && $verificar_1[id_asignacion_cargo]!=$id_asignacion_cargo)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.estado_asignacion='HABILITADO' and ac.id_asignacion_cargo=$id_asignacion_cargo");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$registros_tg = $bd->Consulta("select * from total_ganado where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_tg = $bd->getFila($registros_tg);

			$total_ganado = $registro_tg[total_ganado];

			$registros_apo = $bd->Consulta("select * from conf_aportes where estado='HABILITADO'");
			while($registro_apo = $bd->getFila($registros_apo))
			{
				if ($total_ganado > 0)
				{
					if($registro_apo[rango_inicial] >= 13000)
					{
						if($total_ganado >= $registro_apo[rango_inicial] && $total_ganado <= $registro_apo[rango_final])
						{
							if($registro_apo[tipo_aporte]=='COTIZACION MENSUAL' && $registro_ac[aportante_afp]==0)
							{
								$monto_aporte = 0;
								$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
							}
							else
							{
								$monto_aporte = (($total_ganado - $registro_apo[rango_inicial])*$registro_apo[porc_aporte])/100;
								$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
							}
						}
						else
						{
							$monto_aporte = 0;
							$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
						}	
					}
					else
					{	
						if($total_ganado >= $registro_apo[rango_inicial] && $total_ganado <= $registro_apo[rango_final])
						{
							
							$anios = calculaedad($fecha_calculo, $registro_ac[fecha_nacimiento]);
							if($anios >=65 && $registro_apo[tipo_aporte] == 'PRIMA RIESGO COMUN')
							{
								$monto_aporte = 0;
								$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
							}
							else
							{
								if($registro_apo[tipo_aporte]=='COTIZACION MENSUAL' && $registro_ac[aportante_afp]==0)
								{
									$monto_aporte = 0;
									$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
								}
								else
								{
									$monto_aporte = ($total_ganado*$registro_apo[porc_aporte])/100;
									$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
								}
								
							}
						}
					}
				}
				else
				{
					$monto_aporte = 0;
					$aporte_laboral->registrar_aporte_laboral($mes, $gestion, $registro_apo[tipo_aporte], $registro_apo[porc_aporte], $monto_aporte, $registro_ac[id_asignacion_cargo]);
				}		
				
			}
		}

	}
	else
	{
		echo "Error. Ya se tiene generada el aporte del trabajador para ese periodo";
	}
}
else
echo "Error. tiene que generar las planillas de total ganado... antes de generar planilla de aporte laboral";
?>