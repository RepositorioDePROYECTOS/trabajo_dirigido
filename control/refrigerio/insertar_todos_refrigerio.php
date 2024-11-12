<?php
include("../../modelo/refrigerio.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);
$otros = 0;

$refrigerio = new refrigerio();
$bd = new conexion();
	
	$registros = $bd->Consulta("select * from conf_refrigerio where estado_refrigerio='HABILITADO'");
	$registro = $bd->getFila($registros);
	$monto_refrigerio = $registro[monto_refrigerio];
	$total_refrigerio = $monto_refrigerio*$dias_asistencia;
	$verificar = $bd->Consulta("select * from refrigerio where mes=$mes and gestion=$gestion");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO'");


		while($registro_ac = $bd->getFila($registros_ac))
		{
			
			$refrigerio->registrar_refrigerio($mes,$gestion,$dias_laborables,$dias_asistencia, $monto_refrigerio, $otros, $total_refrigerio, $registro_ac[id_asignacion_cargo]);


		}
	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}







?>