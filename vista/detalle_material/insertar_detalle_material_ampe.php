<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_solicitud_material = $_POST[id_solicitud_material];
    $id_material = (isset($_POST[id_material])) ? $_POST[id_material] : 0;
    $descripcion_material = (isset($_POST[descripcion_material])) ? $_POST[descripcion_material] : '';
    $precio_unitario = (isset($_POST[precio_unitario])) ? $_POST[precio_unitario] : 0;
    $cantidad_solicitada = $_POST[cantidad_solicitada];
    $bd = new conexion(); 
    if($id_material != 0){
      $registro_material = $bd->Consulta("SELECT * from material where id_material=$id_material");
      $registro_m = $bd->getFila($registro_material);
      $descripcion = $registro_m[descripcion];
      $precio_unitario = 0;
      $unidad_medida = $registro_m[unidad_medida];
    }
    else{
      $descripcion = utf8_decode($descripcion_material);
      $unidad_medida= $_POST[unidad_medida];
      $precio_unitario= $precio_unitario;
    }
    $cantidad_despachada = $cantidad_solicitada;
    $verificar_material = $bd->Consulta("SELECT * from detalle_material where id_solicitud_material=$id_solicitud_material and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
    $verificar_m = $bd->getFila($verificar_material);
    if($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida){
      $registros = $bd->Consulta("INSERT INTO detalle_material 
      VALUES('',
            '$descripcion',
            '$unidad_medida',
            '$cantidad_solicitada',
            '$cantidad_despachada',
            '$precio_unitario',
            '$id_solicitud_material'
            )");
      if($bd->numFila_afectada()>0){
        echo json_encode(array("success" => true));
      }
      else{
        echo json_encode(array("success" => false,"message" => "Error no se insertó material"));
      }
    } else{
      echo json_encode(array("success" => false,"message" => utf8_encode('Error ya existe material registrado : '.$registro_m[descripcion].' ('.$registro_m[unidad_medida].')')));
    }
    
?>