<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class suplencia
{
	public $id_suplencia;
	public $mes;
	public $gestion;
	public $fecha_inicio;
	public $fecha_fin;
	public $total_dias;
	public $cargo_suplencia;
	public $salario_mensual;
	public $monto;
	public $id_cargo_suplencia;
	public $id_asignacion_cargo;
	private $bd;

	function suplencia()
	{
		$this->bd = new conexion();
	}
	function registrar_suplencia($mes, $gestion,$fecha_inicio, $fecha_fin, $total_dias, $cargo_suplencia, $salario_mensual, $monto, $id_cargo_suplencia, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into suplencia values('', '$mes', '$gestion', '$fecha_inicio','$fecha_fin','$total_dias', '$cargo_suplencia', '$salario_mensual', '$monto', '$id_cargo_suplencia', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_suplencia($id_suplencia, $mes, $gestion,$fecha_inicio, $fecha_fin, $total_dias, $cargo_suplencia, $salario_mensual, $monto, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("update suplencia set mes='$mes', gestion='$gestion', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', total_dias='$total_dias', cargo_suplencia='$cargo_suplencia', salario_mensual='$salario_mensual', monto='$monto', id_asignacion_cargo='$id_asignacion_cargo' where id_suplencia=$id_suplencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_suplencia)
	{
		$registros = $this->bd->Consulta("delete from suplencia where id_suplencia=$id_suplencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_suplencia($id_suplencia)
	{
		$registros = $this->bd->Consulta("select * from suplencia where id_suplencia=$id_suplencia");
		$registro = $this->bd->getFila($registros);

		$this->id_suplencia = $registro[id_suplencia];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->fecha_inicio = $registro[fecha_inicio];
		$this->fecha_fin = $registro[fecha_fin];
		$this->total_dias = $registro[total_dias];
		$this->cargo_suplencia = $registro[cargo_suplencia];
		$this->salario_mensual = $registro[salario_mensual];
		$this->monto = $registro[monto];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from suplencia $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>