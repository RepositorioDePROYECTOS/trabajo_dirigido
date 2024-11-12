<?php    
    include("../../modelo/usuario_externo.php"); 
    include("../../modelo/expediente.php");  
    include("../../modelo/funciones.php");
    
        $usuario_externo = new usuario_externo();
        $expediente = new expediente();
        $nombre_archivo ="../../archivo/expediente/".$_GET[nom];
        // $nombre_archivo=hola.pdf";
        
        if($usuario_externo->eliminar(security($_GET[id])) && $expediente->eliminar(security($_GET[id_ex])))
        {
            unlink($nombre_archivo);
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.".$_GET[id_ex];
        }
    
?>