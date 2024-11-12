<?php
    include("../../modelo/unidad_medida.php");
    $descripcion = utf8_decode($_POST[descripcion]);
    // echo json_encode(array("success" => false, "message" => $descripcion));
    $unidad_medida = new unidad_medida();
    $result = $unidad_medida->registrar_unidad_medida($descripcion);
    if($result)
    {
        echo json_encode(array("success" => true, "message" => "Datos registrados."));
    }
    else
    {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. El estante ya existe.", "data" => $descripcion));
    }

?>