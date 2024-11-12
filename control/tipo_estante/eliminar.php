<?php    
    include("../../modelo/tipo_estante.php");  
    include("../../modelo/funciones.php");
    
        $tipo_estante = new tipo_estante();
        if($tipo_estante->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>