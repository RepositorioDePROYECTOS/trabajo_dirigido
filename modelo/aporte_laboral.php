<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class aporte_laboral
{
	public $id_aporte_laboral;
	public $mes;
	public $gestion;
	public $tipo_aporte;
	public $porc_aporte;
	public $monto_aporte;
	public $id_asignacion_cargo;
	private $bd;

	function aporte_laboral()
	{
		$this->bd = new conexion();
	}
	function registrar_aporte_laboral($mes, $gestion, $tipo_aporte, $porc_aporte, $monto_aporte, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into aporte_laboral values('','$mes','$gestion', '$tipo_aporte', '$porc_aporte', '$monto_aporte', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_aporte_laboral($id_aporte_laboral, $monto_aporte)
	{
		$registros = $this->bd->Consulta("update aporte_laboral set monto_aporte='$monto_aporte' where id_aporte_laboral=$id_aporte_laboral");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_aporte_laboral)
	{
		$registros = $this->bd->Consulta("delete from aporte_laboral where id_aporte_laboral=$id_aporte_laboral ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from aporte_laboral where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_aporte_laboral($id_aporte_laboral)
	{
		$registros = $this->bd->Consulta("select * from aporte_laboral where id_aporte_laboral=$id_aporte_laboral");
		$registro = $this->bd->getFila($registros);

		$this->id_aporte_laboral = $registro[id_aporte_laboral];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->tipo_aporte = $registro[tipo_aporte];
		$this->porc_aporte = $registro[porc_aporte];
		$this->monto_aporte = $registro[monto_aporte];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from aporte_laboral $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>