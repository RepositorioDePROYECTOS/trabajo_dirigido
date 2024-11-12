<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class horas_extra
{
	public $id_horas_extra;
	public $mes;
	public $gestion;
	public $tipo_he;
	public $factor_calculo;
	public $cantidad;
	public $monto;
	public $id_asignacion_cargo;
	private $bd;

	function horas_extra()
	{
		$this->bd = new conexion();
	}
	function registrar_horas_extra($mes, $gestion,$tipo_he, $factor_calculo, $cantidad, $monto, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into horas_extra values('', '$mes', '$gestion', '$tipo_he','$factor_calculo','$cantidad', '$monto', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_horas_extra($id_horas_extra, $mes, $gestion,$tipo_he, $factor_calculo, $cantidad, $monto, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("update horas_extra set mes='$mes', gestion='$gestion', tipo_he='$tipo_he', factor_calculo='$factor_calculo', cantidad='$cantidad', monto='$monto', id_asignacion_cargo='$id_asignacion_cargo' where id_horas_extra=$id_horas_extra");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_horas_extra)
	{
		$registros = $this->bd->Consulta("delete from horas_extra where id_horas_extra=$id_horas_extra");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_horas_extra($id_horas_extra)
	{
		$registros = $this->bd->Consulta("select * from horas_extra where id_horas_extra=$id_horas_extra");
		$registro = $this->bd->getFila($registros);

		$this->id_horas_extra = $registro[id_horas_extra];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->tipo_he = $registro[tipo_he];
		$this->factor_calculo = $registro[factor_calculo];
		$this->cantidad = $registro[cantidad];
		$this->monto = $registro[monto];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from horas_extra $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>