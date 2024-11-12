<?php    
	session_start();
    
    $titulo = "ELAPAS, Empresa Local De Agua Potable y Alcantarrillado Sucre";
    if(!isset($_SESSION['id_usuario']))
    {
        include_once("vista/paginas/login.php");
    }
    else
    {
        include_once("vista/paginas/admin.php");
    }    
?>

