<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class Partidas_detalle
{
	public $id_partida;
	public $id_partida_detalle;
	public $concepto_partida;
	public $tipo_detalle_partida;
	private $bd;

	function partidas_detalle()
	{
		$this->bd = new Conexion();
	}
	function registrar_partida_detalle($concepto_partida, $tipo_detalle_partida, $id_partida)
	{
		$registros = $this->bd->Consulta("INSERT INTO partidas_detalle (concepto_partida, tipo_detalle_partida, id_partida) values('$concepto_partida', '$tipo_detalle_partida', '$id_partida')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_partida_detalle($id_partida_detalle, $concepto_partida, $tipo_detalle_partida)
	{
		$registros = $this->bd->Consulta("UPDATE partidas_detalle SET concepto_partida='$concepto_partida', tipo_detalle_partida='$tipo_detalle_partida' WHERE id_partida_detalle='$id_partida_detalle'");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_partida_detalle($id_partida_detalle)
	{
		$registros = $this->bd->Consulta("SELECT * FROM partidas_detalle WHERE id_partida_detalle=$id_partida_detalle");
		$registro = $this->bd->getFila($registros);

		$this->id_partida_detalle    = $registro[id_partida_detalle];
		$this->concepto_partida      = $registro[concepto_partida];
		$this->tipo_detalle_partida  = $registro[tipo_detalle_partida];
		$this->id_partida            = $registro[id_partida];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("SELECT * FROM partidas_detalle $where");
			return $registros;
	}    
    function eliminar($id_partida_detalle)
	{
		$registros = $this->bd->Consulta("DELETE FROM partidas_detalle WHERE id_partida_detalle=$id_partida_detalle");
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