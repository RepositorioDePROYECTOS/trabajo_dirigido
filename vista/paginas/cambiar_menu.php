<?php
	session_start();
    if(!isset($_SESSION[estado_menu])){
        $_SESSION[estado_menu] = "cerrado";
    }else{
        if($_SESSION[estado_menu] == "cerrado"){
            $_SESSION[estado_menu] = "abierto";
        }else{
            $_SESSION[estado_menu] = "cerrado";
        }
    }
?>