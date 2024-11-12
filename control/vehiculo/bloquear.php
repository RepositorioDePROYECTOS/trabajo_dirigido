<?php    
    include("../../modelo/vehiculo.php");  
    
        $vehiculo = new vehiculo();
        if($vehiculo->bloquear($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>