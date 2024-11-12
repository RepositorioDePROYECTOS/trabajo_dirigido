<?php    
    include("../../modelo/telefono.php");  
    include("../../modelo/funciones.php");
    
        $telefono = new telefono();
        if($telefono->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
?>