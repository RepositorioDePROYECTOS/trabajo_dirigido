<?php    
    include("../../modelo/rol.php");  
    
        $rol = new rol();
        if($rol->bloquear($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>