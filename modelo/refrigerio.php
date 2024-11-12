<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class refrigerio
{
	public $id_refrigerio;
	public $mes;
	public $gestion;
	public $dias_laborables;
	public $dias_asistencia;
	public $monto_refrigerio;
	public $otros;
	public $total_refrigerio;
	public $id_asignacion_cargo;
	private $bd;

	function refrigerio()
	{
		$this->bd = new conexion();
	}
	function registrar_refrigerio($mes, $gestion, $dias_laborables, $dias_asistencia, $monto_refrigerio, $otros, $total_refrigerio, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into refrigerio values('','$mes', '$gestion', '$dias_laborables', '$dias_asistencia', '$monto_refrigerio', '$otros', '$total_refrigerio', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_refrigerio($id_refrigerio,$dias_laborables, $dias_asistencia, $otros, $total_refrigerio)
	{
		$registros = $this->bd->Consulta("update refrigerio set dias_laborables='$dias_laborables', dias_asistencia='$dias_asistencia', otros='$otros', total_refrigerio='$total_refrigerio' where id_refrigerio=$id_refrigerio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_refrigerio)
	{
		$registros = $this->bd->Consulta("delete from refrigerio where id_refrigerio=$id_refrigerio ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from refrigerio where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_refrigerio($id_refrigerio)
	{
		$registros = $this->bd->Consulta("select * from refrigerio where id_refrigerio=$id_refrigerio");
		$registro = $this->bd->getFila($registros);

		$this->id_refrigerio = $registro[id_refrigerio];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->dias_laborables = $registro[dias_laborables];
		$this->dias_asistencia = $registro[dias_asistencia];
		$this->monto_refrigerio = $registro[monto_refrigerio];
		$this->otros = $registro[otros];
		$this->total_refrigerio = $registro[total_refrigerio];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from refrigerio $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>