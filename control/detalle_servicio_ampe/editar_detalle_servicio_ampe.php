<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");

    $id_detalle_servicio     = (isset($_POST[id_detalle_servicio])) ?  $_POST[id_detalle_servicio] : 0;
    $id_solicitud_servicio   = intval($_POST[id_solicitud_servicio ]);
    $descripcion_servicio    = (isset($_POST[descripcion_servicio])) ? utf8_decode($_POST[descripcion_servicio]) : '';
    $unidad_medida           = (isset($_POST[unidad_medida])) ?        utf8_decode($_POST[unidad_medida]) : '';
    $precio_unitario         = (isset($_POST[precio_unitario]))     ?  floatval($_POST[precio_unitario]) : 0;
    $cantidad_solicitada     = (isset($_POST[cantidad_solicitada])) ?  floatval($_POST[cantidad_solicitada]) : 0;
    $precito_total           = (isset($_POST[precio_total]))        ?  floatval($_POST[precio_total]) : 0;
    // $id_partida              = (isset($_POST[id_partida])) ?           $_POST[id_partida] : '';


    
    $descripcion            = utf8_decode(strtoupper($descripcion_servicio));
    $unidad_medida          = utf8_decode(strtoupper($unidad_medida));
    
    $bd = new conexion(); 
    
    $verificar_servicio = $bd->Consulta("SELECT * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
    $verificar_m = $bd->getFila($verificar_servicio);
    // if($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida){
      $registros = $bd->Consulta("UPDATE detalle_servicio 
      SET descripcion='$descripcion', unidad_medida='$unidad_medida', cantidad_solicitada=$cantidad_solicitada, precio_unitario=$precio_unitario, precio_total=$precito_total WHERE id_detalle_servicio=$id_detalle_servicio");
      //  ,id_partida=$id_partida
      if($bd->numFila_afectada()>0){
        echo json_encode(array("success" => true,"message" => "Registro Modificado"));
      }
      else{
        echo json_encode(array("success" => false,"message" => "Error no se insertó servicio"));
      }
    // } else{
    //   echo json_encode(array("success" => false,"message" => utf8_encode('Error ya existe servicio registrado : '.$descripcion.' ('.$unidad_medida.')')));
    // }
