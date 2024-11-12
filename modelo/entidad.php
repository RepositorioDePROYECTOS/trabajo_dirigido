<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class entidad
{
	public $id_entidad;
	public $nombre_entidad;
	public $ubicacion;
	public $direccion;
	public $telefonos;
	public $correo;
	private $bd;

	function entidad()
	{
		$this->bd = new conexion();
	}
	function registrar_entidad($nombre_entidad, $ubicacion, $direccion, $telefonos, $correo)
	{
		$registros = $this->bd->Consulta("insert into entidad values('','$nombre_entidad', '$ubicacion', '$direccion', '$telefonos', '$correo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_entidad($id_entidad, $nombre_entidad, $ubicacion, $direccion, $telefonos, $correo)
	{
		$registros = $this->bd->Consulta("update entidad set nombre_entidad='$nombre_entidad', ubicacion='$ubicacion', direccion='$direccion', telefonos='$telefonos', correo='$correo' where id_entidad=$id_entidad");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_entidad)
	{
		$registros = $this->bd->Consulta("delete from entidad where id_entidad=$id_entidad ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_entidad($id_entidad)
	{
		$registros = $this->bd->Consulta("select * from entidad where id_entidad=$id_entidad");
		$registro = $this->bd->getFila($registros);

		$this->id_entidad = $registro[id_entidad];
		$this->nombre_entidad = $registro[nombre_entidad];
		$this->ubicacion = $registro[ubicacion];
		$this->direccion = $registro[direccion];
		$this->telefonos = $registro[telefonos];
		$this->correo = $registro[correo];
	}
    function get_entidad_defecto()
	{
		$registros = $this->bd->Consulta("select * from entidad");
		$registro = $this->bd->getFila($registros);

		$this->id_entidad = $registro[id_entidad];
		$this->nombre_entidad = $registro[nombre_entidad];
		$this->ubicacion = $registro[ubicacion];
		$this->direccion = $registro[direccion];
		$this->telefonos = $registro[telefonos];
		$this->correo = $registro[correo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from entidad $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>