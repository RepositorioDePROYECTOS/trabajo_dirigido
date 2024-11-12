<?php    
    include("../../modelo/estante.php");  
    include("../../modelo/funciones.php");
    
        $estante = new estante();
        if($estante->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>