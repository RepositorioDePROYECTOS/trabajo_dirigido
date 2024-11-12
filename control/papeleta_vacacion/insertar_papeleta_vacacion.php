<?php
include("../../modelo/papeleta_vacacion.php");
include("../../modelo/detalle_vacacion.php");
include("../../modelo/funciones.php");

referer_permit();

$id_detalle_vacacion = utf8_decode($_POST[id_detalle_vacacion]);
$fecha_solicitud = utf8_decode($_POST[fecha_solicitud]);
$fecha_inicio = utf8_decode($_POST[fecha_inicio]);
$fecha_fin = utf8_decode($_POST[fecha_fin]);
$dias_solicitados = utf8_decode($_POST[dias_solicitados]);
$estado = 'SOLICITADO';
$autorizado_por = utf8_decode($_POST[autorizado_por]);
$observacion = utf8_decode($_POST[observacion]);
$restante = utf8_decode($_POST[restantes]);

$bd = new conexion();
$papeleta_vacacion = new papeleta_vacacion();
$detalle_vacacion = new detalle_vacacion();

// echo $id_detalle_vacacion . "<br>" . $fecha_solicitud . "<br>" . $fecha_inicio . "<br>" . $fecha_fin . "<br>" . $dias_solicitados . "<br>" . $estado . "<br>" . $autorizado_por . "<br>" . $observacion . "<br>" . $restante;

// $registros = $bd->Consulta("SELECT * from detalle_vacacion where id_detalle_vacacion=$id_detalle_vacacion");
// $registro = $bd->getFila($registros);

// $saldo = $registro[cantidad_dias] - $registro[dias_utilizados];

if($restante>=$dias_solicitados)
{
	$result = $papeleta_vacacion->registrar_papeleta_vacacion($fecha_solicitud, $fecha_inicio, $fecha_fin, $dias_solicitados, $estado, $autorizado_por, $observacion, $id_detalle_vacacion, $restante);

	if($result)
	{
		echo "Datos registrados.";
	}
	else
	{
		echo "Ocurri&oacute; un Error.";
	}
}
else
{
	echo "Error. No tiene saldo suficiente en sus dias de vacacion";
}



?>