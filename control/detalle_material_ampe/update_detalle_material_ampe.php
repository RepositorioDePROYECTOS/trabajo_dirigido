<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");

    referer_permit();

    $id_detalle_material      = $_POST[id_detalle_material];
    $existencia               = (isset($_POST[existencia])) ? $_POST[existencia] : '';
    // Con Existencia
    $id_material              = (isset($_POST[id_material])) ? $_POST[id_material] : 0;
    $precio_unitario          = (isset($_POST[precio_unitario])) ? $_POST[precio_unitario] : 0;
    $cantidad_solicitada      = $_POST[cantidad_solicitada];
    $cantidad_solicitada_old  = $_POST[cantidad_solicitada_old];
    $unidad_medida_old        = utf8_decode(mb_strtoupper($_POST[unidad_medida_old]));
    $descripcion_old          = $_POST[descripcion_old];
    // Sin Existencia
    $descripcion_material     = (isset($_POST[descripcion_material])) ? utf8_decode(mb_strtoupper($_POST[descripcion_material])) : '';
    // $id_partida               = (isset($_POST[id_partida])) ? $_POST[id_partida] : '';
    $unidad_medida_sn         = (isset($_POST[unidad_medida_sn])) ? utf8_decode(mb_strtoupper($_POST[unidad_medida_sn])) : '';
    $cantidad_sn              = (isset($_POST[cantidad_sn])) ? $_POST[cantidad_sn] : '';
    $precio_unitario_sn       = (isset($_POST[precio_unitario_sn])) ? $_POST[precio_unitario_sn] : '';
    $precio_referencia        = (isset($_POST[precio_referencia])) ? $_POST[precio_referencia] : '';

    $bd = new conexion(); 

    $validacion = $bd->Consulta("SELECT * FROM detalle_material WHERE (id_detalle_material=$id_detalle_material AND cantidad_despachada=$cantidad_solicitada_old AND descripcion='$descripcion_old')");
    $validar = $bd->getFila($validacion);

    if($existencia == 'SI'){
        // echo json_encode(array("success" => false,"message" => "ID: ".var_dump($validar)));
        // echo json_encode(array("success" => false,"message" => "Id:".$id_detalle_material." Cantidad: ".$cantidad_solicitada_old.' Descripcion: '.$descripcion_old));
        if($id_material == 0){
            // Validamos que no exista o no se haya fijado el Material
            echo json_encode(array("success" => false,"message" => "No selecciono ningun Material"));
            // echo 'No selecciono ningun Material';
        }
        if($validar){
            $cambios = $bd->Consulta("UPDATE detalle_material SET cantidad_solicitada=$cantidad_solicitada, cantidad_despachada=$cantidad_solicitada WHERE id_detalle_material=$id_detalle_material");
        } else {
            $registro_material = $bd->Consulta("SELECT * from material where id_material=$id_material");
            $registro_m = $bd->getFila($registro_material);

            $cambios = $bd->Consulta("UPDATE detalle_material SET descripcion=$registro_m[descripcion], unidad_medida=$registro_m[unidad_medida], cantidad_solicitada=$cantidad_solicitada, cantidad_despachada=$cantidad_solicitada WHERE id_detalle_material=$id_detalle_material");
        }
        if($bd->numFila_afectada()>=0){
            echo json_encode(array("success" => true,"message" => "Se actualizo el registro!"));
            // echo 'Se actualizo el registro!';
        }
        else{
            echo json_encode(array("success" => false,"message" => "Error al actualizar el registro!"));
            // echo 'Error al actualizar el registro!';
        }
    } else {
        // if($id_partida == 0){
        //     // Validamos que no exista o no se haya fijado una Partida
        //     echo json_encode(array("success" => false,"message" => "No selecciono ninguna Partida"));
        //     // echo "No selecciono ninguna Partida";
        // }
        $cambios = $bd->Consulta("UPDATE detalle_material SET descripcion='$descripcion_material', unidad_medida='$unidad_medida_sn', cantidad_solicitada=$cantidad_sn, cantidad_despachada=$cantidad_sn, precio_unitario=$precio_unitario_sn, precio_total=$precio_referencia WHERE id_detalle_material=$id_detalle_material");
        // , id_partida=$id_partida
        if($bd->numFila_afectada()>=0){
            echo json_encode(array("success" => true,"message" => "Se actualizo el registro!"));
            // echo "Se actualizo el registro!";
        }
        else{
            echo json_encode(array("success" => false,"message" => "Error al actualizar!"));
            // echo "UPDATE detalle_material SET descripcion='$descripcion_material', unidad_medida='$unidad_medida_sn', cantidad_solicitada=$cantidad_sn, cantidad_despachada=$cantidad_sn, precio_unitario=$precio_unitario_sn, precio_total=$precio_referencia, id_partida=$id_partida WHERE id_detalle_material=$id_detalle_material";
        }
    }

    
?>