<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$bd = new conexion();

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_solicitud_material = $_POST[id_solicitud_material];
$partidas              = $_POST[partidas];
$con_detalles          = $_POST[con_detalles];
foreach ($partidas as $key) {
    list($id_detalle, $id_partida) = explode('-', $key);
    // $pruebas[] = "id_detalle: $id_detalle, id_partida: $id_partida"; // para mostrar los datos que llegan
    $result = $bd->Consulta("UPDATE detalle_material set id_partida=$id_partida where id_detalle_material =$id_detalle");
}

if($bd->numFila_afectada())
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}
