<?php    
    include("../../modelo/expediente.php");  
    include("../../modelo/funciones.php");
    
        $expediente = new expediente();
        if($expediente->eliminar(security($_GET[id])))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>