<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_solicitud_activo = $_POST[id_solicitud_activo];
    $id_activo = (isset($_POST[id_activo])) ? $_POST[id_activo] : 0;
    $descripcion_activo = (isset($_POST[descripcion_activo])) ? $_POST[descripcion_activo] : '';
    $precio_unitario = (isset($_POST[precio_unitario])) ? $_POST[precio_unitario] : 0;
    $cantidad_solicitada = $_POST[cantidad_solicitada];
    $bd = new conexion(); 
    if($id_activo != 0){
      $registro_activo = $bd->Consulta("SELECT * from activo where id_activo=$id_activo");
      $registro_m = $bd->getFila($registro_activo);
      $descripcion = $registro_m[descripcion];
      $precio_unitario = 0;
      $unidad_medida = $registro_m[unidad_medida];
    }
    else{
      $descripcion = utf8_decode($descripcion_activo);
      $unidad_medida= $_POST[unidad_medida];
      $precio_unitario= $precio_unitario;
    }
    $cantidad_despachada = $cantidad_solicitada;
    $verificar_activo = $bd->Consulta("SELECT * from detalle_activo where id_solicitud_activo=$id_solicitud_activo and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
    $verificar_m = $bd->getFila($verificar_activo);
    if($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida){
      $registros = $bd->Consulta("INSERT INTO detalle_activo 
      VALUES('',
            '$descripcion',
            '$unidad_medida',
            '$cantidad_solicitada',
            '$cantidad_despachada',
            '$precio_unitario',
            '$id_solicitud_activo'
            )");
      if($bd->numFila_afectada()>0){
        echo json_encode(array("success" => true));
      }
      else{
        echo json_encode(array("success" => false,"message" => "Error no se insertó activo"));
      }
    } else{
      echo json_encode(array("success" => false,"message" => utf8_encode('Error ya existe activo registrado : '.$registro_m[descripcion].' ('.$registro_m[unidad_medida].')')));
    }
    
?>