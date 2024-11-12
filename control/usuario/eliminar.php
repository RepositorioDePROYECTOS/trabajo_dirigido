<?php    
    include("../../modelo/usuario.php");  
    include("../../modelo/funciones.php");
    
        $usuario = new usuario();
        if($usuario->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
?>