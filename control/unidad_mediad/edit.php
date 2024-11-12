<?php    
    include("../../modelo/unidad_medida.php");  
    include("../../modelo/funciones.php");
    
        $unidad_medida = new unidad_medida();
        $id            = security($_GET[id]);
        $unidad_medida->get_unidad($id);
        if($unidad_medida)
        {
            echo json_encode(array("success" => true, "message" => "Datos registrados.", "data" => utf8_encode($unidad_medida->descripcion)));
        }
        else
        {
            echo json_encode(array("success" => true, "message" => "Ocurri&oacute; un error."));
        }
?>