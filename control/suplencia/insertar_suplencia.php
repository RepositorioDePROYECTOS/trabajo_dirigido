<?php
include("../../modelo/suplencia.php");
include("../../modelo/asignacion_cargo.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$fecha_inicio = utf8_decode($_POST[fecha_inicio]);
$fecha_fin = utf8_decode($_POST[fecha_fin]);
$total_dias = utf8_decode($_POST[total_dias]);
$id_cargo_suplencia = utf8_decode($_POST[id_cargo_suplencia]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$suplencia = new suplencia();
$asignacion_cargo = new asignacion_cargo();
$bd = new conexion();

$asuplir = $bd->Consulta("select * from cargo where id_cargo=$id_cargo_suplencia");
$suplir = $bd->getFila($asuplir);


$asignacion_cargo->get_asignacion_cargo($id_asignacion_cargo);


$monto = (($suplir[salario_mensual] - $asignacion_cargo->salario)/30)*$total_dias;

$result = $suplencia->registrar_suplencia($mes, $gestion, $fecha_inicio, $fecha_fin, $total_dias, $suplir[descripcion], $suplir[salario_mensual], $monto, $id_cargo_suplencia, $id_asignacion_cargo);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>