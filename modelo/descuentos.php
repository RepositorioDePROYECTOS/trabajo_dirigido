<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class descuentos
{
	public $id_descuentos;
	public $mes;
	public $gestion;
	public $nombre_descuento;
	public $monto;
	public $id_asignacion_cargo;
	private $bd;

	function descuentos()
	{
		$this->bd = new conexion();
	}
	function registrar_descuentos($mes, $gestion, $nombre_descuento, $monto, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into descuentos values('','$mes','$gestion', '$nombre_descuento', '$monto', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_descuentos($id_descuentos, $mes, $gestion, $nombre_descuento, $monto, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("update descuentos set mes='$mes', gestion='$gestion',nombre_descuento='$nombre_descuento', monto='$monto', id_asignacion_cargo='$id_asignacion_cargo' where id_descuentos=$id_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_descuentos)
	{
		$registros = $this->bd->Consulta("delete from descuentos where id_descuentos=$id_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_descuentos($id_descuentos)
	{
		$registros = $this->bd->Consulta("select * from descuentos where id_descuentos=$id_descuentos");
		$registro = $this->bd->getFila($registros);

		$this->id_descuentos = $registro[id_descuentos];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->nombre_descuento = $registro[nombre_descuento];
		$this->monto = $registro[monto];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from descuentos $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>