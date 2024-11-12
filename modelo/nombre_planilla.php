<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class nombre_planilla
{
	public $id_nombre_planilla;
	public $mes;
	public $gestion;
	public $nombre_planilla;
	public $fecha_creacion;
	public $estado;
	private $bd;

	function nombre_planilla()
	{
		$this->bd = new conexion();
	}
	function registrar_nombre_planilla($mes, $gestion, $nombre_planilla, $fecha_creacion, $estado)
	{
		$registros = $this->bd->Consulta("insert into nombre_planilla values('','$mes', '$gestion', '$nombre_planilla', '$fecha_creacion', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_nombre_planilla($id_nombre_planilla, $mes, $gestion, $nombre_planilla, $fecha_creacion, $estado)
	{
		$registros = $this->bd->Consulta("update nombre_planilla set mes='$mes', gestion='$gestion', nombre_planilla='$nombre_planilla', fecha_creacion='$fecha_creacion', estado='$estado' where id_nombre_planilla=$id_nombre_planilla");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_nombre_planilla)
	{
		$registros = $this->bd->Consulta("delete from nombre_planilla where id_nombre_planilla=$id_nombre_planilla ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_nombre_planilla($id_nombre_planilla)
	{
		$registros = $this->bd->Consulta("select * from nombre_planilla where id_nombre_planilla=$id_nombre_planilla");
		$registro = $this->bd->getFila($registros);

		$this->id_nombre_planilla = $registro[id_nombre_planilla];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->nombre_planilla = $registro[nombre_planilla];
		$this->fecha_creacion = $registro[fecha_creacion];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from nombre_planilla $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>