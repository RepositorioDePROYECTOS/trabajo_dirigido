<?php 
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    include("../../modelo/proveedor.php");
    
    $id_proveedor      = $_POST[id_proveedor];
    $nombre_proveedor  = utf8_decode($_POST[nombre_proveedor]);
    $nit               = utf8_decode($_POST[nit]);
    // $contacto          = utf8_decode($_POST[contacto]);
    // $doc_contacto      = utf8_decode($_POST[doc_contacto]);
    $direccion         = utf8_decode($_POST[direccion]);
    $telefono          = utf8_decode($_POST[telefono]);
    $celular           = utf8_decode($_POST[celular]);
    // $correo            = utf8_decode($_POST[correo]);
    $observaciones     = utf8_decode($_POST[observacion]);
    $id_usuario        = utf8_decode($_POST[id_usuario]);
    $estado            = "A";
   
    $bd = new conexion();
    $users = $bd->Consulta("SELECT cuenta FROM usuario WHERE id_usuario=$id_usuario");
    $user  = $bd->getFila($users);
    
    $proveedor = new proveedor;
    $update = $proveedor->editar_proveedor($id_proveedor,$nombre_proveedor,$nit,$direccion,$telefono,$celular,$observaciones,$user[cuenta]);
    if($bd->numFila_afectada() > 0){
        echo "Acci&oacute;n completada con &eacute;xito";
    } else {
        echo "Ocuri&oacute; un Error.";
    }
