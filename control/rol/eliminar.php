<?php    
    include("../../modelo/rol.php");  
    include("../../modelo/funciones.php");
    
        $rol = new rol();
        if($rol->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
?>