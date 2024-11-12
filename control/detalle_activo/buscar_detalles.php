<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $bd = new conexion(); 
    
    $detalle_activo = $_POST[detalle_activo];

    // $registro_activo = $bd->Consulta("SELECT descripcion
    // FROM detalle_activo
    // WHERE descripcion LIKE CONCAT('%', :inputValue, '%');", array(':inputValue' => $detalle_activo));
    $registros = array();
    $registro_activo = $bd->Consulta("SELECT descripcion FROM detalle_activo WHERE descripcion LIKE '$detalle_activo%' GROUP BY descripcion");
    while($registro_m = $bd->getFila($registro_activo)){
        array_push($registros,array(
            'descripcion' => utf8_encode($registro_m[descripcion])
        ));
    }
    // $ejemplo = "SELECT descripcion FROM detalle_activo WHERE descripcion like '$detalle_activo'%";
    echo json_encode(array("success" => true, "message" => $registros));
?>