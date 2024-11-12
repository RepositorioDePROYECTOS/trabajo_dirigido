<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_solicitud_servicio   = $_POST[id_solicitud_servicio];
$id_servicio             = $_POST[id_servicio];
$descripcion_servicio    = $_POST[descripcion_servicio];
$precio_unitario         = floatval($_POST[precio_unitario]);
$cantidad_solicitada     = floatval($_POST[cantidad_solicitada]);
$precito_total           = floatval($_POST[precio_total]);
// $id_partida              = $_POST[id_partida];
$descripcion             = utf8_decode(mb_strtoupper($descripcion_servicio));
$unidad_medida           = utf8_decode(mb_strtoupper($_POST[unidad_medida]));
// $precio_unitario = $precio_unitario;
$total_usado          = (isset($_POST[total_usado])) ? floatval($_POST[total_usado]) : 0;

// echo json_encode(array("success" => false, "descripcion" =>$descripcion_servicio, "unidad" => $unidad_medida));
$bd = new conexion();
if(($total_usado + $precito_total) <= 50000) {

  $verificar_servicio = $bd->Consulta("SELECT * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
  $verificar_m = $bd->getFila($verificar_servicio);
  if ($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida) {
    $registros = $bd->Consulta("INSERT INTO detalle_servicio (descripcion, unidad_medida, cantidad_solicitada, precio_unitario, precio_total, id_solicitud_servicio)
        VALUES('$descripcion',
              '$unidad_medida',
              '$cantidad_solicitada',
              '$precio_unitario',
              '$precito_total',
              '$id_solicitud_servicio'
              )");
    if ($bd->numFila_afectada() > 0) {
      echo json_encode(array("success" => true));
    } else {
      echo json_encode(array("success" => false, "message" => "Error no se insertó servicio"));
    }
  } else {
    echo json_encode(array("success" => false, "message" => utf8_encode('Error ya existe servicio registrado : ' . $descripcion . ' (' . $unidad_medida . ')')));
  }
} else {
  echo json_encode(array("success" => false, "message" => "Error ya supero los 50.000,00 Bs, tiene acumulado: ".($total_usado + $precito_total)));
}
