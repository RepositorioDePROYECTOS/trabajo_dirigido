<?php

if(!class_exists("conexion"))
    include ("conexion.php");

class Sesion 
{
      private $bd;
      public $id_usuario;
      public $cuenta;
      public $correo;
      public $nombre_ap;
      public $nivel;
      
    //constructor de la clase sesion
    function Sesion()
    {
        $this->bd = new Conexion();
        $this->bd->Conectar();        
    }
    function Iniciar($usuario,$pass)
    {
        //$pass = md5($pass);
        $datos = $this->bd->Consulta("select * from usuario where (correo='$usuario' or cuenta='$usuario') and password='$pass' and estado_usuario=1");
        
        if ($this->bd->numFila($datos)>0)
        {            
            $dato = $this->id_usuario = $this->bd->getFila($datos);
            $this->id_usuario = $dato[id_usuario];
            $this->cuenta = $dato[cuenta];    
            $this->correo = $dato[correo];
            
            $this->nombre_ap = utf8_encode($dato[nombre_ap]);
            $this->nombre_completo = utf8_encode($dato[nombre_apellidos]);
            $this->nivel = $dato[nivel];
                        
            $ip = $_SERVER[REMOTE_ADDR];
            $fecha_i = date("Y-m-d H:i:s");
            
            $this->bd->Consulta("update usuario set fecha_ultimo_ingreso='$fecha_i', ip_actual='$ip' where id_usuario=$dato[id_usuario]");
            
            return true;            
        } 
        else
        {
            return false;
        }
            
    }
   
    function Cerrar($id_usuario)
    {
            $ip = $_SERVER["REMOTE_ADDR"];
            $fecha_i = date("Y-m-d H:i:s");
            $this->bd->Consulta("update usuario set ip_ultimo=ip_actual where id_usuario=$id_usuario");
    }
}
?>