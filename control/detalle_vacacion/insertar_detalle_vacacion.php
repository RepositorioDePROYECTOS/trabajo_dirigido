<?php
include("../../modelo/detalle_vacacion.php");
include("../../modelo/vacacion.php");
include("../../modelo/funciones.php");

referer_permit();

$id_vacacion = utf8_decode($_POST[id_vacacion]);
$gestion_inicio = utf8_decode($_POST[gestion_inicio]);
$gestion_fin = utf8_decode($_POST[gestion_fin]);
$fecha_calculo = utf8_decode($_POST[fecha_calculo]);
$cantidad_dias = utf8_decode($_POST[cantidad_dias]);
$dias_utilizados = utf8_decode($_POST[dias_utilizados]);
$bd = new conexion();
$vacacion = new vacacion();
$detalle_vacacion = new detalle_vacacion();
$registros = $bd->Consulta("select * from detalle_vacacion where id_vacacion=$id_vacacion and gestion_inicio=$gestion_inicio");
$registro = $bd->getFila($registros);
if($registro[gestion_inicio]!=$gestion_inicio && $gestion_inicio<$gestion_fin)
{
	$result = $detalle_vacacion->registrar_detalle_vacacion($gestion_inicio, $gestion_fin, $fecha_calculo, $cantidad_dias, $dias_utilizados, $id_vacacion);
	if($result)
	{
		$result1 = $vacacion->modificar_vacacion_acumulada($id_vacacion,$cantidad_dias);
		if($result1)
		{
			echo "Datos registrados.";
		}
		else
		{
			echo "Error al modificar dias acumulados";
		}
		
	}
	else
	{
		echo "Ocurri&oacute; un Error.";
	}
}
else
{
	echo "Error. Ya existe vacacion para ese periodo";
}



?>