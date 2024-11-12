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
$factor_calculo = $conf_otros_descuentos->factor_calculo;
$verificar_1 = $bd->getFila($verificar);
if(empty($verificar_1))
{
	if($a_quienes == 1)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo  where estado_asignacion='HABILITADO' and sindicato=1");
	}
	else
	{
		if($a_quienes == 0)
		{
			$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO'");
		}
		else
		{
			if($a_quienes == 2)
			{
				$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO' and sindicato=0");
			}
		}	
		
	}
	
	while($registro_ac = $bd->getFila($registros_ac))
	{
		if($de_donde == 2)
		{
			eval("\$monto_od = \$registro_ac[salario]$factor_calculo;");
			$otros_descuentos->registrar_otros_descuentos($mes, $gestion, $conf_otros_descuentos->descripcion, $conf_otros_descuentos->factor_calculo, round($monto_od,2), $registro_ac[id_asignacion_cargo]);
		}
			
	}	
}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}

?>