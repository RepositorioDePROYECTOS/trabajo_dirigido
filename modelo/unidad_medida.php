<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class unidad_medida
{
	public $id_unidad_medida;
	public $descripcion;
	private $bd;

	function unidad_medida()
	{
		$this->bd = new Conexion();
	}
	function registrar_unidad_medida($descripcion)
	{
		$registros = $this->bd->Consulta("INSERT INTO unidad_de_medida (descripcion) VALUES('$descripcion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_unidad_medida($id_unidad_medida, $descripcion)
	{
	   $registros = $this->bd->Consulta("UPDATE unidad_de_medida SET descripcion='$descripcion' WHERE id_unidad_medida=$id_unidad_medida");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_unidad($id_unidad_medida)
	{
		$registros = $this->bd->Consulta("select * from unidad_de_medida where id_unidad_medida=$id_unidad_medida");
		$registro = $this->bd->getFila($registros);

		$this->id_unidad_medida = $registro[id_unidad_medida];
		$this->descripcion = $registro[descripcion];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from unidad_de_medida $where");
			return $registros;
	}    
    function bloquear($id_unidad_medida)
	{
		$registros = $this->bd->Consulta("update unidad_de_medida set descripcion=0 where id_unidad_medida=$id_unidad_medida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_unidad_medida)
	{
		$registros = $this->bd->Consulta("update unidad_de_medida set descripcion=1 where id_unidad_medida=$id_unidad_medida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_unidad_medida)
	{
		$registros = $this->bd->Consulta("delete from unidad_de_medida where id_unidad_medida=$id_unidad_medida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function __destroy()
	{
		$unidad_medida = $this->bd->Cerrar();
	}
}
 
?>