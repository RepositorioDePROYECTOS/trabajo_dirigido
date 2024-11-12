<?php    
    include("../../modelo/estante.php");  
    
        $estante = new estante();
        if($estante->habilitar($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>