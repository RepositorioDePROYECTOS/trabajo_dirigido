<?php    
    include("../../modelo/caja.php");  
    
        $caja = new caja();
        if($caja->habilitar($_GET[id]))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
    
?>