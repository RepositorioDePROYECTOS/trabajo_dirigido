<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class usuario
{
	public $id_usuario;
	public $correo;
	public $cuenta;
	public $nombre_ap;
	public $password;
	public $nivel;
	public $fecha_registro;
	public $fecha_actualizacion;
	public $fecha_ultimo_ingreso;
	public $ip_actual;
	public $ip_ultimo;
	public $estado_usuario;
	public $id_trabajador;
	public $id_rol;
	private $bd;

	function usuario()
	{
		$this->bd = new Conexion();
	}
	function registrar_usuario($correo, $cuenta, $nombre_ap, $password, $nivel, $fecha_registro, $fecha_actualizacion, $fecha_ultimo_ingreso, $ip_actual, $ip_ultimo, $estado_usuario, $id_trabajador, $id_rol)
	{
		$registros = $this->bd->Consulta("insert into usuario (`id_usuario`, `correo`, `cuenta`, `nombre_apellidos`, `password`, `nivel`, `fecha_registro`, `fecha_actualizacion`, `fecha_ultimo_ingreso`, `ip_actual`, `ip_ultimo`, `estado_usuario`, `id_trabajador`, `id_eventual`, `id_rol`) values('','$correo', '$cuenta', '$nombre_ap', '$password', '$nivel', '$fecha_registro', '$fecha_actualizacion', '$fecha_ultimo_ingreso', '$ip_actual', '$ip_ultimo', '$estado_usuario', $id_trabajador, '',$id_rol)");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function registrar_eventual($correo, $cuenta, $nombre_ap, $password, $nivel, $fecha_registro, $fecha_actualizacion, $fecha_ultimo_ingreso, $ip_actual, $ip_ultimo, $estado_usuario, $id_trabajador, $id_rol)
	{
		$registros = $this->bd->Consulta("INSERT into usuario (`id_usuario`, `correo`, `cuenta`, `nombre_apellidos`, `password`, `nivel`, `fecha_registro`, `fecha_actualizacion`, `fecha_ultimo_ingreso`, `ip_actual`, `ip_ultimo`, `estado_usuario`, `id_trabajador`, `id_eventual`, `id_rol`) values('','$correo', '$cuenta', '$nombre_ap', '$password', '$nivel', '$fecha_registro', '$fecha_actualizacion', '$fecha_ultimo_ingreso', '$ip_actual', '$ip_ultimo', '$estado_usuario', '',$id_trabajador, $id_rol)");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_usuario($id_usuario, $correo, $cuenta, $password, $nivel, $fecha_actualizacion, $id_rol)
	{
	   if(empty($password))
            $registros = $this->bd->Consulta("update usuario set correo='$correo', cuenta='$cuenta', nivel='$nivel', fecha_actualizacion='$fecha_actualizacion', id_rol='$id_rol' where id_usuario=$id_usuario");
       else        
	   		$registros = $this->bd->Consulta("update usuario set correo='$correo', cuenta='$cuenta', password='$password', nivel='$nivel', fecha_actualizacion='$fecha_actualizacion', id_rol='$id_rol' where id_usuario=$id_usuario");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_password($id, $password) {
		$registros = $this->bd->Consulta("UPDATE usuario SET password='$password' WHERE id_usuario=$id");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_usuario($id_usuario)
	{
		$registros = $this->bd->Consulta("select * from usuario where id_usuario=$id_usuario");
		$registro = $this->bd->getFila($registros);

		$this->id_usuario = $registro[id_usuario];
		$this->correo = $registro[correo];
		$this->cuenta = $registro[cuenta];
		$this->nombre_ap = $registro[nombre_apellidos];
		$this->password = $registro[password];
		$this->nivel = $registro[nivel];
		$this->fecha_registro = $registro[fecha_registro];
		$this->fecha_actualizacion = $registro[fecha_actualizacion];
		$this->fecha_ultimo_ingreso = $registro[fecha_ultimo_ingreso];
		$this->ip_actual = $registro[ip_actual];
		$this->ip_ultimo = $registro[ip_ultimo];
		$this->estado_usuario = $registro[estado_usuario];
		$this->id_trabajador = $registro[id_trabajador];
		$this->id_rol = $registro[id_rol];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from usuario $where");
			return $registros;
	}    
    function bloquear($id_usuario)
	{
		$registros = $this->bd->Consulta("update usuario set estado_usuario=0 where id_usuario=$id_usuario");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_usuario)
	{
		$registros = $this->bd->Consulta("update usuario set estado_usuario=1 where id_usuario=$id_usuario");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_usuario)
	{
		$registros = $this->bd->Consulta("delete from usuario where id_usuario=$id_usuario");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>