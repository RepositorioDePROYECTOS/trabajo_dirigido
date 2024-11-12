<?php    
    include("../../modelo/lavado.php");  
    include("../../modelo/funciones.php");
    
        $lavado = new lavado();
        if($lavado->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
?>