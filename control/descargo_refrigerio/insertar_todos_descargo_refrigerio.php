<?php
include("../../modelo/descargo_refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$descargo_refrigerio = new descargo_refrigerio();
$bd = new conexion();
$monto_descargo = 0;
$registros_c = $bd->Consulta("select * from conf_refrigerio where estado_refrigerio='HABILITADO' AND descripcion='REFRIGERIO PERSONAL DE PLANTA'");
$registro_c = $bd->getFila($registros_c);

	$verificar = $bd->Consulta("select * from descargo_refrigerio where mes=$mes and gestion=$gestion");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
	{
		$verificars_ar = $bd->Consulta("select * from asistencia_refrigerio where mes=$mes and gestion=$gestion");
		$verificar_ar = $bd->getFila($verificars_ar);
		if($verificar_ar[gestion]==$gestion && $verificar_ar[mes]==$mes)
		{
			$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join asistencia_refrigerio a on ac.id_asignacion_cargo=a.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and a.mes=$mes and a.gestion=$gestion");

			while($registro_ac = $bd->getFila($registros_ac))
			{
				$dias_laborables = $registro_ac[dias_laborables];
				$monto_refrigerio = round($dias_laborables*$registro_c[monto_refrigerio],2);
				$retencion = round($monto_refrigerio*0.13,0);
				$total_refrigerio = $monto_refrigerio - $retencion;
				$descargo_refrigerio->registrar_descargo_refrigerio($mes,$gestion,$monto_descargo, $monto_refrigerio, $retencion, $total_refrigerio, $registro_ac[id_asistencia_refrigerio]);
			}
		}
		else
		{
			echo "Error. No existe planilla asistencia refrigerio de ese periodo";
		}
	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}







?>