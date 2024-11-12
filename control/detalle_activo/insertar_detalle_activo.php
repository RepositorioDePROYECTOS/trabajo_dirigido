<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
$existencia           = $_POST[existencia];

$id_solicitud_activo  = $_POST[id_solicitud_activo];
$id_activo            = (isset($_POST[id_activo])) ? $_POST[id_activo] : 0;
$precio_unitario      = (isset($_POST[precio_unitario])) ? $_POST[precio_unitario] : 0;
$cantidad_solicitada  = $_POST[cantidad_solicitada];

$cantidad_sn          = (isset($_POST[cantidad_sn])) ? utf8_decode($_POST[cantidad_sn]) : 0;
$unidad_medida_sn     = (isset($_POST[unidad_medida_sn])) ? utf8_decode(mb_strtoupper($_POST[unidad_medida_sn])) : '';
$descripcion_activo   = (isset($_POST[descripcion_activo])) ? utf8_decode(mb_strtoupper($_POST[descripcion_activo])) : '';
// $id_partida           = intval($_POST[id_partida]);
$precio_unitario_sn   = (isset($_POST[precio_unitario_sn])) ? floatval($_POST[precio_unitario_sn]) : '';
$precio_referencia    = (isset($_POST[precio_referencia])) ? floatval($_POST[precio_referencia]) : '';
$total_usado          = (isset($_POST[total_usado])) ? floatval($_POST[total_usado]) : 0;
$bd = new conexion();
// echo json_encode(array("success"=>false,"message"=>"existencia: ".$existencia." id_activo: ".$id_activo." precio unitario: ".$precio_unitario." cantidad_solicitada: ".$cantidad_solicitada." No cantidad: ".$cantidad_sn." No unidad: ".$unidad_medida_sn." No Descripcion: ".$descripcion_activo." No Partida: ".$id_partida." No Precio unitario: ".$precio_unitario_sn." No precio Total: ".$precio_referencia));
if ($id_activo != 0) {
  $registro_activo = $bd->Consulta("SELECT * from activo where id_activo=$id_activo");
  $registro_m = $bd->getFila($registro_activo);
  $descripcion = $registro_m[descripcion];
  $precio_unitario = 0;
  $unidad_medida = $registro_m[unidad_medida];
  // echo json_encode(array("success"=>false,"message"=>"ERROR AQUI SI ACTIVO"));
} else {
  $descripcion = utf8_decode($descripcion_activo);
  $unidad_medida = utf8_decode($unidad_medida_sn);
  $precio_unitario = utf8_decode($precio_unitario_sn);
  // echo json_encode(array("success"=>false,"message"=>"ERROR AQUI"));
}
$cantidad_despachada = $cantidad_solicitada;
$verificar_activo = $bd->Consulta("SELECT * from detalle_activo where id_solicitud_activo=$id_solicitud_activo and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
$verificar_m = $bd->getFila($verificar_activo);
// echo json_encode(array("success"=>false,"message"=>"SELECT * from detalle_activo where id_solicitud_activo=$id_solicitud_activo and descripcion='$descripcion' and unidad_medida='$unidad_medida'"));
// echo json_encode(array("success"=>false,"message"=>"INSERT INTO detalle_activo (descripcion, unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, precio_total, id_partida,  id_solicitud_activo ) VALUES('$descripcion_activo', '$unidad_medida_sn', '$cantidad_sn', '$cantidad_sn', '$precio_unitario_sn', '$precio_referencia', '$id_partida', '$id_solicitud_activo' )"))
if ($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida) {
  if ($existencia == 'SI') {
    $registros = $bd->Consulta("INSERT INTO detalle_activo (unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, id_solicitud_activo ) VALUES('$unidad_medida','$cantidad_solicitada','$cantidad_despachada','$precio_unitario','$id_solicitud_activo')");
    // echo json_encode(array("success"=>false,"message"=>"INSERT INTO detalle_activo (unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, id_solicitud_activo ) VALUES('$unidad_medida','$cantidad_solicitada','$cantidad_despachada','$precio_unitario','$id_solicitud_activo')"));
    if ($bd->numFila_afectada() > 0) {
      echo json_encode(array("success" => true));
    } else {
      echo json_encode(array("success" => false, "message" => "Error no se insertó activo"));
    }
  } else {
    if (($total_usado + $precio_referencia) <= 50000) {
      $registros = $bd->Consulta("INSERT INTO detalle_activo (descripcion, unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, precio_total,  id_solicitud_activo ) VALUES('$descripcion_activo', '$unidad_medida_sn', '$cantidad_sn', '$cantidad_sn', '$precio_unitario_sn', '$precio_referencia', '$id_solicitud_activo' )");
      // echo json_encode(array("success"=>false,"message"=>"INSERT INTO detalle_activo (descripcion, unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, precio_total, id_partida,  id_solicitud_activo ) VALUES('$descripcion_activo', '$unidad_medida_sn', '$cantidad_sn', '$cantidad_sn', '$precio_unitario_sn', '$precio_referencia', '$id_partida', '$id_solicitud_activo' )"));
      if ($bd->numFila_afectada() > 0) {
        echo json_encode(array("success" => true));
      } else {
        echo json_encode(array("success" => false, "message" => "Error no se insertó activo"));
      }
    } else {
      echo json_encode(array("success" => false, "message" => utf8_encode('Error, supera los 50.000,00 Bs, tiene acumulado: ' . ($total_usado + $precio_referencia))));
    }
  }
} else {
  echo json_encode(array("success" => false, "message" => utf8_encode('Error ya existe activo registrado : ' . $registro_m[descripcion] . ' (' . $registro_m[unidad_medida] . ')')));
}
