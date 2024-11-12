<?php    
    include("../../modelo/salida.php");  
    include("../../modelo/funciones.php");
    
        $salida = new salida();
        if($salida->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>