<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_material = $_GET[id_detalle_material];
    $bd = new conexion(); 
    
    $registro_material = $bd->Consulta("select * from material where id_material=$id_material");
    $registro_m = $bd->getFila($registro_material);
    echo json_encode(array("success" => true,
                            "cantidad" => $registro_m[cantidad],
                            "unidad_medida" => $registro_m[unidad_medida],
                        ));
?>