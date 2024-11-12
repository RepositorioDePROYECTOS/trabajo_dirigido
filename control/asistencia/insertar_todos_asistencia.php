<?php
include("../../modelo/asistencia.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$dias_laborables = utf8_decode($_POST[dias_laborables]);
$dias_asistencia = utf8_decode($_POST[dias_asistencia]);

$asistencia = new asistencia();
$bd = new conexion();

	$verificar = $bd->Consulta("select * from asistencia where mes=$mes and gestion=$gestion");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO'");


		while($registro_ac = $bd->getFila($registros_ac))
		{
			
			$asistencia->registrar_asistencia($mes,$gestion,$dias_asistencia,$dias_laborables, $registro_ac[id_asignacion_cargo]);


		}
	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}







?>