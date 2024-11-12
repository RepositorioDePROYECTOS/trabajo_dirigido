<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class tipo_salida
{
	public $id_tipo_salida;
	public $nombre;
	private $bd;

	function tipo_salida()
	{
		$this->bd = new Conexion();
	}
	function registrar_tipo_salida($nombre)
	{
		$registros = $this->bd->Consulta("insert into tipo_salida values('', '$nombre')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_tipo_salida($id_tipo_salida, $nombre)
	{
	   $registros = $this->bd->Consulta("update tipo_salida set nombre='$nombre' where id_tipo_salida=$id_tipo_salida");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_salida($id_tipo_salida)
	{
		$registros = $this->bd->Consulta("select * from tipo_salida where id_tipo_salida=$id_tipo_salida");
		$registro = $this->bd->getFila($registros);

		$this->id_tipo_salida = $registro[id_tipo_salida];
		$this->nombre = $registro[nombre];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from tipo_salida $where");
			return $registros;
	}    
    function bloquear($id_tipo_salida)
	{
		$registros = $this->bd->Consulta("update tipo_salida set descripcion=0 where id_tipo_salida=$id_tipo_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_tipo_salida)
	{
		$registros = $this->bd->Consulta("update tipo_estante set descripcion=1 where id_tipo_salida=$id_tipo_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_tipo_salida)
	{
		$registros = $this->bd->Consulta("delete from tipo_salida where id_tipo_salida=$id_tipo_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function __destroy()
	{
		$tipo_salida = $this->bd->Cerrar();
	}
}
 
?>