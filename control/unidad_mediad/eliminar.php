<?php    
    include("../../modelo/unidad_medida.php");  
    include("../../modelo/funciones.php");
    
        $unidad_medida = new unidad_medida();
        if($unidad_medida->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>