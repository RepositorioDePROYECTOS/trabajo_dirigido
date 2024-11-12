<?php    
    include("../../modelo/telefono.php");  
    
        $telefono = new telefono();
        if($telefono->bloquear($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>