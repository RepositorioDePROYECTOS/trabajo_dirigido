<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_detalle_activo = intval($_POST[id_detalle_activo]);
    $cantidad_despachada = floatval($_POST[cantidad_despachada]);
    $bd = new conexion(); 


    $registros = $bd->Consulta("SELECT * from detalle_activo where id_detalle_activo=$id_detalle_activo");
    $registro = $bd->getFila($registros);
    // print_r($registro);
    if($id_detalle_activo >= 0 && ($cantidad_despachada >= 0 && $cantidad_despachada <= $registro[cantidad_solicitada])){

        $actualizar_cantidad = $bd->Consulta("UPDATE detalle_activo set cantidad_despachada=$cantidad_despachada where id_detalle_activo=$id_detalle_activo");
        if($bd->numFila_afectada()>=0){
            echo json_encode(array("success" => true,"message" => "Cantidad modificada con exito del activo:".utf8_encode( $registro[descripcion])));
        }
        else{
            echo json_encode(array("success" => false,"message" => "Error no se editó activo"));
        }
    }else{
        echo json_encode(array("success" => false,"message" => "La cantidad a despachar no tiene que ser mayor a la cantidad solicitada"));
    }

    
?>