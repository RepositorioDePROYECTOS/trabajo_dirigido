<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class fila 
{
	public $id_fila;
	public $nro_fila;
	public $estado;
	public $id_estante;

	private $bd;

	function fila()
	{
		$this->bd = new Conexion();
	}
	function registrar_fila($nro_fila, $estado, $id_estante)
	{
		$registros = $this->bd->Consulta("insert into fila values('', '$nro_fila', '$estado', '$id_estante')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_fila($id_fila, $nro_fila, $id_estante)
	{
	    $registros = $this->bd->Consulta("update fila set nro_fila='$nro_fila', id_estante='$id_estante' where id_fila=$id_fila");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_fila($id_fila)
	{
		$registros = $this->bd->Consulta("select * from fila where id_fila=$id_fila");
		$registro = $this->bd->getFila($registros);

		$this->id_fila = $registro[id_fila];
		$this->nro_fila = $registro[nro_fila];
		$this->estado = $registro[estado];
		$this->id_estante = $registro[id_estante];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from fila $where");
			return $registros;
	}    
    function bloquear($id_fila)
	{
		$registros = $this->bd->Consulta("update fila set estado=0 where id_fila=$id_fila");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_fila)
	{
		$registros = $this->bd->Consulta("update fila set estado=1 where id_fila=$id_fila");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_fila)
	{
		$registros = $this->bd->Consulta("delete from fila where id_fila=$id_fila");
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