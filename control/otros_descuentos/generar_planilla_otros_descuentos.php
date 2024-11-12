<?php
include("../../modelo/otros_descuentos.php");
include("../../modelo/conf_otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$id_conf_otros_descuentos = utf8_decode($_POST[id_conf_otros_descuentos]);
$a_quienes = utf8_decode($_POST[a_quienes]);
$de_donde = utf8_decode($_POST[de_donde]);

$otros_descuentos = new otros_descuentos();
$conf_otros_descuentos = new conf_otros_descuentos();
$bd = new conexion();

$conf_otros_descuentos->get_conf_otros_descuentos($id_conf_otros_descuentos);

$verificar = $bd->Consulta("select * from otros_descuentos where mes=$mes and gestion=$gestion and descripcion='$conf_otros_descuentos->descripcion'");
$verificar_tg = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion");
$factor_calculo = $conf_otros_descuentos->factor_calculo;
$verificar_1 = $bd->getFila($verificar);
$verificar_tg_1 = $bd->getFila($verificar_tg);
if(empty($verificar_1))
{
	if(!empty($verificar_tg_1))
	{
		if($a_quienes == 1)
		{
			$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join total_ganado tg on ac.id_asignacion_cargo=tg.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and tg.mes=$mes and tg.gestion=$gestion and sindicato=1");
		}
		else
		{
			if($a_quienes == 0)
			{
				$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join total_ganado tg on ac.id_asignacion_cargo=tg.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and tg.mes=$mes and tg.gestion=$gestion");
			}
			else
			{
				if($a_quienes == 2)
				{
					$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join total_ganado tg on ac.id_asignacion_cargo=tg.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and tg.mes=$mes and tg.gestion=$gestion and sindicato=0");
				}
			}	
			
		}
		
		while($registro_ac = $bd->getFila($registros_ac))
		{
			if($de_donde == 1)
			{
				eval("\$monto_od = \$registro_ac[total_ganado]$factor_calculo;");
				$otros_descuentos->registrar_otros_descuentos($mes, $gestion, $conf_otros_descuentos->descripcion, $conf_otros_descuentos->factor_calculo, round($monto_od,2), $registro_ac[id_asignacion_cargo]);
			}
			else
			{
				eval("\$monto_od = \$registro_ac[haber_basico]$factor_calculo;");
				$otros_descuentos->registrar_otros_descuentos($mes, $gestion, $conf_otros_descuentos->descripcion, $conf_otros_descuentos->factor_calculo, round($monto_od,2), $registro_ac[id_asignacion_cargo]);
			}
				
		}
	}
	else
	{
	echo "Error. No se puede generar otros descuentos falta planilla Total Ganado";
	}
	
}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}

?>