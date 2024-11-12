<?php
    include("../../modelo/unidad_medida.php");
    $descripcion      = utf8_decode($_POST[descripcion]);
    $id_unidad_medida = utf8_decode($_POST[id_unidad_medida]);
    $unidad_medida = new unidad_medida();
    $result = $unidad_medida->modificar_unidad_medida($id_unidad_medida, $descripcion);
    if($result)
    {
        echo json_encode(array("success" => true, "message" => "Datos registrados."));
    }
    else
    {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. El estante ya existe."));
    }

?>