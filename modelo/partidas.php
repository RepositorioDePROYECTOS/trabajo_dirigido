<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class Partidas 
{
	public $id_partida;
	public $codigo_partida;
	public $nombre_partida;
	public $glosa_partida;
	public $tipo_partida;
	public $estado_partida;
	private $bd;

	function partidas()
	{
		$this->bd = new Conexion();
	}
	function registrar_partida($codigo_partida, $nombre_partida, $glosa_partida, $tipo_partida, $estado_partida)
	{
		$registros = $this->bd->Consulta("INSERT INTO partidas (codigo_partida, nombre_partida, glosa_partida, tipo_partida, estado_partida) values('$codigo_partida', '$nombre_partida', '$glosa_partida', '$tipo_partida', '$estado_partida')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_partida($id_partida, $codigo_partida, $nombre_partida, $glosa_partida, $tipo_partida, $estado_partida)
	{
		$registros = $this->bd->Consulta("UPDATE partidas SET codigo_partida='$codigo_partida', nombre_partida='$nombre_partida', glosa_partida='$glosa_partida', tipo_partida='$tipo_partida', estado_partida='$estado_partida' where id_partida='$id_partida'");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_partida($id_partida)
	{
		$registros = $this->bd->Consulta("SELECT * FROM partidas WHERE id_partida=$id_partida");
		$registro = $this->bd->getFila($registros);

		$this->id_partida     = $registro[id_partida];
		$this->codigo_partida = $registro[codigo_partida];
		$this->nombre_partida = $registro[nombre_partida];
		$this->glosa_partida = $registro[glosa_partida];
		$this->tipo_partida   = $registro[tipo_partida];
		$this->estado_partida = $registro[estado_partida];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("SELECT * FROM partidas $where");
			return $registros;
	}    
    function bloquear($id_partida)
	{
		$registros = $this->bd->Consulta("UPDATE partidas SET estado_partida=0 WHERE id_partida=$id_partida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_partida)
	{
		$registros = $this->bd->Consulta("UPDATE partidas SET estado_partida=1 WHERE id_partida=$id_partida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_partida)
	{
		$registros = $this->bd->Consulta("DELETE FROM partidas WHERE id_partida=$id_partida");
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