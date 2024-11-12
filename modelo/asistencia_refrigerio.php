<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class asistencia_refrigerio
{
	public $id_asistencia_refrigerio;
	public $mes;
	public $gestion;
	public $dias_laborables;
	public $dias_asistencia;
	public $id_asignacion_cargo;
	private $bd;

	function asistencia_refrigerio()
	{
		$this->bd = new conexion();
	}
	function registrar_asistencia_refrigerio($mes, $gestion, $dias_laborables, $dias_asistencia, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into asistencia_refrigerio values('','$mes', '$gestion', '$dias_laborables', '$dias_asistencia', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_asistencia_refrigerio($id_asistencia_refrigerio,$dias_laborables, $dias_asistencia)
	{
		$registros = $this->bd->Consulta("update asistencia_refrigerio set dias_laborables='$dias_laborables', dias_asistencia='$dias_asistencia' where id_asistencia_refrigerio=$id_asistencia_refrigerio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_asistencia_refrigerio)
	{
		$registros = $this->bd->Consulta("delete from asistencia_refrigerio where id_asistencia_refrigerio=$id_asistencia_refrigerio ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from asistencia_refrigerio where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_asistencia_refrigerio($id_asistencia_refrigerio)
	{
		$registros = $this->bd->Consulta("select * from asistencia_refrigerio where id_asistencia_refrigerio=$id_asistencia_refrigerio");
		$registro = $this->bd->getFila($registros);

		$this->id_asistencia_refrigerio = $registro[id_asistencia_refrigerio];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->dias_laborables = $registro[dias_laborables];
		$this->dias_asistencia = $registro[dias_asistencia];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from asistencia_refrigerio $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>