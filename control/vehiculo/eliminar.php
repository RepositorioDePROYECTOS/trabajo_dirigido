<?php    
    include("../../modelo/vehiculo.php");  
    include("../../modelo/funciones.php");
    
        $vehiculo = new vehiculo();
        if($vehiculo->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
    
?>