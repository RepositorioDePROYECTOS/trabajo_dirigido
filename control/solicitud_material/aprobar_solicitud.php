<?php
include("../../modelo/conexion.php");
include("../../modelo/solicitud_material.php");
include("../../modelo/funciones.php");

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_solicitud_material = $_POST[id];
$id_usuario            = (!empty($_POST[id_usuario])) ? intval($_POST[id_usuario]) : '';
$check_certificado     = $_POST[check_certificacion] == 1 ? 'SI' : 'NO';
$check_poa     		   = $_POST[check_poa] == 1 ? 'SI' : 'NO';
$check_pac     		   = $_POST[check_pac] == 1 ? 'SI' : 'NO';
$aprobar     		   = $_POST[aprobar] == 1 ? 'SI' : 'NO';
$totales 			   = $_POST[totales];
$fecha                 = date("Y-m-d H:i:s");
$observacion = "";
$estado_consulta = "";
$bd = new conexion();
// print_r($_POST);
$solicitud_material = new solicitud_material();

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

$trabajador = $bd->Consulta("SELECT t.id_trabajador, u.nivel FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
$t = $bd->getFila($trabajador);
$id_t = $t[id_trabajador];
$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud_material AND tipo_solicitud='material'");
$derivacion   = $bd->getFila($derivaciones);
$observacion .= 'Se rechazo la solicitud debido a que no cumle los requisitos de: ';
if ($check_certificado == 'NO') {
	$observacion .= 'No tiene certificacíon presupuestaria';
}
if ($check_poa == 'NO') {
	$observacion .= 'No tiene certificacíon del POA';
}
if ($totales > 20000 && $check_pac == 'NO') {
	$observacion .= 'No tiene certificacíon del PAC';
}
if ($aprobar == 'SI') {
	$result = $solicitud_material->autorizar($id_solicitud_material);
	$estado = "aprobado por " . strtoupper($t[nivel]);
	$estado_consulta = 'aprobado';
} else {
	$result = $solicitud_material->rechazar_solicitud($id_solicitud_material, $observacion);
	$estado = "rechazado por " . strtoupper($t[nivel]);
	$estado_consulta = 'rechazado';
}
if ($result) {
	$derivacion_estado = $bd->Consulta("UPDATE derivaciones set estado_derivacion='$estado_consulta',check_certificado='$check_certificado',check_poa='$check_poa',check_pac='$check_pac' where id_derivacion=$derivacion[id_derivacion]");
	$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_material, $id_t, 'material', '$tipo_trabajador', '$estado')");
	if (($derivacion_estado && $historico) == TRUE) {
		echo "Accion Registrada.";
	} else {
		echo "Ocuri&oacute; un Error Registrando.";
	}
} else {
	echo "Ocuri&oacute; un Error.";
}
