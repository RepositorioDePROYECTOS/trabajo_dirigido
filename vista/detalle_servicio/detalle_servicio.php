<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id_servicio = $_GET[id_detalle_servicio];
    $bd = new conexion(); 
    
    $registro_servicio = $bd->Consulta("select * from servicio where id_servicio=$id_servicio");
    $registro_m = $bd->getFila($registro_servicio);
    echo json_encode(array("success" => true,
                            "cantidad" => $registro_m[cantidad],
                            "unidad_medida" => $registro_m[unidad_medida],
                        ));
?>