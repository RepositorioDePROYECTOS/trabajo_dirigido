<?php
    session_start();
    include("../../modelo/sesion.php");  
    
        $sesion = new Sesion();
            if(isset($_SESSION['id_usuario']))
            {   
                $sesion->Cerrar($_SESSION[id_usuario]);
                unset($_SESSION[id_usuario]);
                                
                session_destroy();
                echo "Cerrando Sesi&oacute;n";
            }
            else
            {
                echo "Ocurri&oacute; un error";
            }
            
?>
