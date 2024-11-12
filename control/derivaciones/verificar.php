<?php
include('../../modelo/derivaciones.php');
include("../../modelo/funciones.php");

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_derivacion = security($_GET[id]);
// $respuesta = $_GET[respuesta];
$fecha_respuesta   = date('Y-m-d H:i:s');
// variables para el historico
$id_solicitud = "";
$id_trabajador = "";
$estado = 'verificado';
// buscamos datos sobre la derivacion
$solicituds = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion=$id_derivacion");
$solcitud = $bd->getFila($solicituds);
if ($solcitud[tipo_solicitud] == "material") {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$solcitud[id_solicitud]");
    $registro_sol = $bd->getFila($registros_solicitud);
    $id_solicitud = $registro_sol[id_solicitud_material];
    $id_trabajador = $registro_sol[id_usuario];
} elseif ($solcitud[tipo_solicitud] == "servicio") {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$solcitud[id_solicitud]");
    $registro_sol = $bd->getFila($registros_solicitud);
    $id_solicitud = $registro_sol[id_solicitud_servicio];
    $id_trabajador = $registro_sol[id_usuario];
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$solcitud[id_solicitud]");
    $registro_sol = $bd->getFila($registros_solicitud);
    $id_solicitud = $registro_sol[id_solicitud_activo];
    $id_trabajador = $registro_sol[id_usuario];
}


$derivacion = new derivaciones();
if ($respuesta == "SI") {
    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud,estado) VALUES ('$id_derivacion', $id_solicitud, $id_trabajador, '$solcitud[tipo_solicitud]', '$estado')");
    $verificado = $bd->Consulta("UPDATE derivaciones set fecha_respuesta='$fecha_respuesta', estado_derivacion='verificado' where id_derivacion =$id");
} else {
    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) 
    VALUES ('$id_derivacion', $id_solicitud, $id_trabajador, '$solcitud[tipo_solicitud]', 'devuelto')");
}
if ($bd->numFila_afectada() > 0) {
    echo "Acci&oacute;n completada con &eacute;xito";
} else {
    echo "Ocuri&oacute; un Error.";
}
