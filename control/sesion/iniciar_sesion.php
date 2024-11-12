<?php
    session_start();
    include("../../modelo/funciones.php");
    include("../../modelo/sesion.php");  
    
        $sesion = new Sesion();
        
        $email = security($_POST['username']);
        $pass = security($_POST['password']);
        
        $resp = array();        
        $resp['submitted_data'] = $_POST;
        
        $login_status = 'invalid';
        
        if($sesion->Iniciar($email,$pass))
        {   
            $_SESSION['id_usuario'] = $sesion->id_usuario;
            $_SESSION['cuenta'] = $sesion->cuenta;
            $_SESSION['correo'] = $sesion->correo;
            $_SESSION['nombre_usuario'] = $sesion->nombre_ap;
            $_SESSION['nombre_completo'] = $sesion->nombre_completo;
            $_SESSION['nivel'] = $sesion->nivel;
            
            if($sesion->nivel == 'Contabilidad' || $sesion->nivel == 'Aux Contabilidad'){
                include("../../modelo/configuracion_contable.php");
               //$configuracion_contable = new configuracion_contable();
                $configuracion_contable->get_configuracion_vigente();
                list($gestion) = explode("-", $configuracion_contable->inicio_gestion) ;
                
                $_SESSION['id_configuracion'] = $configuracion_contable->id_configuracion_contable;                  
                $_SESSION['gestion'] = $gestion;
            }
            
            $login_status = 'success';
        }
            
        $resp['login_status'] = $login_status;
        
        if($login_status == 'success')
        {
        	$resp['redirect_url'] = '';
        }
        
        
        echo json_encode($resp);
            
?> 
