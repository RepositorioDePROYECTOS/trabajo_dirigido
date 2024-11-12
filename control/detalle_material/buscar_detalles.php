<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $bd = new conexion(); 
    
    $detalle_material = $_POST[detalle_material];

    // $registro_material = $bd->Consulta("SELECT descripcion
    // FROM detalle_material
    // WHERE descripcion LIKE CONCAT('%', :inputValue, '%');", array(':inputValue' => $detalle_material));
    $registros = array();
    $registro_material = $bd->Consulta("SELECT descripcion FROM detalle_material WHERE descripcion LIKE '$detalle_material%' GROUP BY descripcion");
    while($registro_m = $bd->getFila($registro_material)){
        array_push($registros,array(
            'descripcion' => utf8_encode($registro_m[descripcion])
        ));
    }
    // $ejemplo = "SELECT descripcion FROM detalle_material WHERE descripcion like '$detalle_material'%";
    echo json_encode(array("success" => true, "message" => $registros));
?>