<?php 
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
$id   = $_GET[id];
// $tipo = $_GET[tipo];
$bd = new conexion();
$consulta = $bd->Consulta("SELECT id_detalle FROM requisitos WHERE id_detalle=$id");
$datos = $bd->getFila($consulta);
if($datos[id_detalle] != 0 || $datos[id_detalle] != NULL){
    echo json_encode(array("success" => true, "id"=> $id,"message" => "ID registrado anteriormente ".$id));
}
else{
    echo json_encode(array("success" => false, "id"=> $id, "message" => 'Sin Registros '.$id));
    // echo json_encode(array("success" => false, "message" => "SELECT * FROM requisitos WHERE id_detalle=$id"));
}
?>