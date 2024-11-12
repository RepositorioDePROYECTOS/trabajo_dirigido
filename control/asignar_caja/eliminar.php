<?php    
    include("../../modelo/caja.php");  
    include("../../modelo/funciones.php");
    
        $caja = new caja();
        if($caja->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>