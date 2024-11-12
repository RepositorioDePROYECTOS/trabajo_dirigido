<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/solicitud_servicio.php");
include("../../modelo/solicitud_activo.php");
include("../../modelo/solicitud_material.php");

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$bd = new conexion(); 
$id_trabajador     = $_POST[id_trabajador];

$message = false;
$array = array();
$res = array();

$consulta = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id_trabajador AND tipo = 'CURSOS' ORDER BY id_file DESC");
while($data = $bd->getFila($consulta)) {
    $array = array(
        "id_trabajador" => $data[id_trabajador],
        "tipo" => utf8_encode($data[tipo]),
        "fecha" => $data[fecha_creacion]
    );
    array_push($res, $array);
}
if($res) $message = true;
echo json_encode(array("message"=>$message, "info" => $res));

?>