<?php
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");
include("../../modelo/conexion.php");

referer_permit();
setlocale(LC_TIME,"es_ES");
ini_set('date.timezone','America/La_Paz');

$bd = new conexion();

$id_solicitud_material = $_POST[id_solicitud_material];
$observacion           = $_POST[observacion];
$id_usuario            = $_POST[id_usuario];
$fecha_respuesta       = date("Y-m-d H:i:s");

// Verificacion
$tipo_trabajador = "";
$verificacion_usuario = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador WHERE u.id_usuario=$id_usuario");
$verificacion_usuarios = $bd->getFila($verificacion_usuario);
if($verificacion_usuarios[id_trabajador]){
	$tipo_trabajador = "ITEM";
} else {
	// $usuario = $bd->Consulta("SELECT t.id_eventual as id_trabajador FROM eventual as t INNER JOIN usuario as u ON u.id_eventual = t.id_eventual WHERE u.id_usuario=$id_usuario");
	// $user = $bd->getFila($usuario);
	$tipo_trabajador = "EVENTUAL";
}

$derivaciones = $bd->Consulta("SELECT t.id_trabajador, d.id_derivacion, u.cuenta
	FROM derivaciones as d
	INNER JOIN solicitud_material as s ON s.id_solicitud_material = d.id_solciitud
	INNER JOIN usuario AS u ON u.id_usuario = s.id_usuario 
	INNER JOIN trabajador AS t ON t.id_trabajador = u.id_trabajador
	WHERE d.id_solicitud=$id_solicitud_material AND d.tipo_solicitud='material'");
$derivacion = $bd->getFila($derivaciones);
$estado = "rechazado por ".strtoupper($derivacion[cuenta]);

$solicitud_material = new solicitud_material();
$result = $solicitud_material->rechazar_solicitud($id_solicitud_material, $observacion);
if($result)
{
	$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_tranajador, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_material, $derivacion[id_trabajador], 'material', '$tipo_trabajador', '$estado')");
	echo "Solicitud de material rechazado.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>