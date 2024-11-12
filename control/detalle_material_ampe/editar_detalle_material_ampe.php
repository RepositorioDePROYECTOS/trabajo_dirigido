<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_detalle_material = intval($_POST[id_detalle_material]);
    $cantidad_despachada = floatval($_POST[cantidad_despachada]);
    $bd = new conexion(); 


    $registros = $bd->Consulta("SELECT * from detalle_material where id_detalle_material=$id_detalle_material");
    $registro = $bd->getFila($registros);
    // print_r($registro);
    if($id_detalle_material >= 0 && ($cantidad_despachada >= 0 && $cantidad_despachada <= $registro[cantidad_solicitada])){

        $actualizar_cantidad = $bd->Consulta("UPDATE detalle_material set cantidad_despachada=$cantidad_despachada where id_detalle_material=$id_detalle_material");
        if($bd->numFila_afectada()>=0){
            echo json_encode(array("success" => true,"message" => "Cantidad modificada con exito del material:".utf8_encode( $registro[descripcion])));
        }
        else{
            echo json_encode(array("success" => false,"message" => "Error no se editó material"));
        }
    }else{
        echo json_encode(array("success" => false,"message" => "La cantidad a despachar no tiene que ser mayor a la cantidad solicitada"));
    }

    
?>