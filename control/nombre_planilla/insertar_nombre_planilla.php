<?php
include("../../modelo/nombre_planilla.php");
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = $_POST[mes];
$gestion = $_POST[gestion];
$descripcion = utf8_decode($_POST[nombre_planilla]);
$fecha_creacion = $_POST[fecha_creacion];
$estado = utf8_decode($_POST[estado]);

$nombre_planilla = new nombre_planilla();
$planilla = new planilla();
$bd = new conexion();
$result = $nombre_planilla->registrar_nombre_planilla($mes, $gestion, $descripcion, $fecha_creacion, $estado);

if($result)
{
	$ides = $bd->Consulta("select max(id_nombre_planilla) from nombre_planilla");
	$id_nombre_planilla = $bd->getFila($ides);
	$trabajadores = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='ACTIVO'");
	while($trabajador = $bd->getFila($trabajadores))
    {
    	$planilla->registrar_planilla($numero_mes, $gestion, $trabajador[item], $trabajador[ci], $trabajador[nombres], $trabajador[apellidos], $trabajador[cargo], $trabajador[fecha_ingreso], 30, $trabajador[salario], 0, 0, 0, 0, 0, 0, 0, 0, 0, 'GENERADO', $id_nombre_planilla[0]);	
    }
    echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>