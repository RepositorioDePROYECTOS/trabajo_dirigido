<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class asistencia
{
	public $id_asistencia;
	public $mes;
	public $gestion;
	public $dias_asistencia;
	public $dias_laborables;
	public $id_asignacion_cargo;
	private $bd;

	function asistencia()
	{
		$this->bd = new conexion();
	}
	function registrar_asistencia($mes, $gestion, $dias_asistencia, $dias_laborables, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into asistencia values('','$mes', '$gestion', '$dias_asistencia', '$dias_laborables', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_asistencia($id_asistencia, $dias_asistencia)
	{
		$registros = $this->bd->Consulta("update asistencia set dias_asistencia='$dias_asistencia' where id_asistencia=$id_asistencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_asistencia)
	{
		$registros = $this->bd->Consulta("delete from asistencia where id_asistencia=$id_asistencia ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from asistencia where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_asistencia($id_asistencia)
	{
		$registros = $this->bd->Consulta("select * from asistencia where id_asistencia=$id_asistencia");
		$registro = $this->bd->getFila($registros);

		$this->id_asistencia = $registro[id_asistencia];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->dias_asistencia = $registro[dias_asistencia];
		$this->dias_laborables = $registro[dias_laborables];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from asistencia $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>