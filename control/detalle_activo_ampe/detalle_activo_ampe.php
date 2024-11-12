<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_activo = $_GET[id_detalle_activo];
    $bd = new conexion(); 
    
    $registro_activo = $bd->Consulta("select * from activo where id_activo=$id_activo");
    $registro_m = $bd->getFila($registro_activo);
    echo json_encode(array("success" => true,
                            "cantidad" => $registro_m[cantidad],
                            "unidad_medida" => $registro_m[unidad_medida],
                        ));
?>