<?php    
    include("../../modelo/usuario.php");  
    
        $usuario = new usuario();
        if($usuario->habilitar($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>