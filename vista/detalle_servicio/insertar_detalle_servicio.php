<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_solicitud_servicio = $_POST[id_solicitud_servicio];
    $id_servicio = (isset($_POST[id_servicio])) ? $_POST[id_servicio] : 0;
    $descripcion_servicio = (isset($_POST[descripcion_servicio])) ? $_POST[descripcion_servicio] : '';
    $precio_unitario = (isset($_POST[precio_unitario])) ? $_POST[precio_unitario] : 0;
    $cantidad_solicitada = $_POST[cantidad_solicitada];
    $total_usado = $_POST[total_usado];
    $bd = new conexion(); 

    $descripcion = utf8_decode(mb_strtoupper($descripcion_servicio));
    $unidad_medida= utf8_decode(mb_strtoupper($_POST[unidad_medida]));

    
    $verificar_servicio = $bd->Consulta("SELECT * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
    $verificar_m = $bd->getFila($verificar_servicio);
    if($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida){
      if(($precio_unitario * $cantidad_solicitada) + $total_usado < 50000 ){
        $registros = $bd->Consulta("INSERT INTO detalle_servicio 
        VALUES('',
              '$descripcion',
              '$unidad_medida',
              '$cantidad_solicitada',
              '$precio_unitario',
              '$id_solicitud_servicio'
              )");
        if($bd->numFila_afectada()>0){
          echo json_encode(array("success" => true));
        }
        else{
          echo json_encode(array("success" => false,"message" => "Error no se insertó servicio"));
        }
      } else {
        echo json_encode(array("success" => false,"message" => utf8_encode('Error ya supero los 50.000,00 Bs con: '.$descripcion.' ('.$unidad_medida.')')));
      }
    } else{
      echo json_encode(array("success" => false,"message" => utf8_encode('Error ya existe servicio registrado : '.($precio_unitario * $cantidad_solicitada) + $total_usado.')')));
    }
    
?>