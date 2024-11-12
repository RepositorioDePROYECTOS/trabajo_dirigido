<?php
include("../../modelo/papeleta_vacacion.php");
include("../../modelo/uso_vacacion.php");
include("../../modelo/detalle_vacacion.php");
include("../../modelo/vacacion.php");
include("../../modelo/funciones.php");
// session_start();
referer_permit();
date_default_timezone_set('America/La_Paz');
$fecha_registro = date("Y-m-d");
$id_papeleta_vacacion = security($_GET[id]);

$papeleta_vacacion = new papeleta_vacacion();
$uso_vacacion = new uso_vacacion();
$detalle_vacacion = new detalle_vacacion();
$vacacion = new vacacion();
$bd = new conexion();

$registros =  $bd->Consulta("select * from papeleta_vacacion pv inner join detalle_vacacion dv on pv.id_detalle_vacacion=dv.id_detalle_vacacion where pv.id_papeleta_vacacion=$id_papeleta_vacacion");
$registro = $bd->getFila($registros);

$result = $papeleta_vacacion->aprobar($id_papeleta_vacacion);
if($result)
{
	
	$result1 = $uso_vacacion->registrar_uso_vacacion($fecha_registro, $registro[gestion_inicio], $registro[gestion_fin], $registro[fecha_inicio], $registro[fecha_fin], $registro[dias_solicitados], $id_papeleta_vacacion);
	if($result1)
	{
		$result2 = $detalle_vacacion->modificar_dias_utilizados($registro[id_detalle_vacacion], $registro[dias_solicitados]);
		if($result2)
		{
			$result3 = $vacacion->actualizar_vacacion_acumulada($registro[id_vacacion]);
			if($result3)
			{
				echo "Acci&oacute;n completada con &eacute;xito";
			}
			else
			{
				echo "Error al registrar  vacaci&oacute;n acumulada";
			}
			
		}
		else
		{
			echo "Error al registrar uso de vacaci&oacute;n en el detalle";
		}
		
	}
	else
	{
		echo "Error al registrar uso de vacaci&oacute;n.";
	}
	
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>