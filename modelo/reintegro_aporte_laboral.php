<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class reintegro_aporte_laboral
{
	public $id_aporte_laboral_reintegro;
	public $mes_reintegro;
	public $gestion_reintegro;
	public $tipo_aporte_reintegro;
	public $porc_aporte_reintegro;
	public $monto_aporte_reintegro;
	public $id_aporte_laboral;
	private $bd;

	function reintegro_aporte_laboral()
	{
		$this->bd = new conexion();
	}
	function registrar_reintegro_aporte_laboral($mes_reintegro, $gestion_reintegro, $tipo_aporte_reintegro, $porc_aporte_reintegro, $monto_aporte_reintegro, $id_aporte_laboral)
	{
		$registros = $this->bd->Consulta("insert into reintegro_aporte_laboral values('','$mes_reintegro','$gestion_reintegro', '$tipo_aporte_reintegro', '$porc_aporte_reintegro', '$monto_aporte_reintegro', '$id_aporte_laboral')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_reintegro_aporte_laboral($id_aporte_laboral_reintegro, $monto_aporte_reintegro)
	{
		$registros = $this->bd->Consulta("update reintegro_aporte_laboral set monto_aporte_reintegro='$monto_aporte_reintegro' where id_aporte_laboral_reintegro=$id_aporte_laboral_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_aporte_laboral_reintegro)
	{
		$registros = $this->bd->Consulta("delete from reintegro_aporte_laboral where id_aporte_laboral_reintegro=$id_aporte_laboral_reintegro ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes_reintegro, $gestion_reintegro)
	{
		$registros = $this->bd->Consulta("delete from reintegro_aporte_laboral where mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_reintegro_aporte_laboral($id_aporte_laboral_reintegro)
	{
		$registros = $this->bd->Consulta("select * from reintegro_aporte_laboral where id_aporte_laboral_reintegro=$id_aporte_laboral_reintegro");
		$registro = $this->bd->getFila($registros);

		$this->id_aporte_laboral_reintegro = $registro[id_aporte_laboral_reintegro];
		$this->mes_reintegro = $registro[mes_reintegro];
		$this->gestion_reintegro = $registro[gestion_reintegro];
		$this->tipo_aporte_reintegro = $registro[tipo_aporte_reintegro];
		$this->porc_aporte_reintegro = $registro[porc_aporte_reintegro];
		$this->monto_aporte_reintegro = $registro[monto_aporte_reintegro];
		$this->id_aporte_laboral = $registro[id_aporte_laboral];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from reintegro_aporte_laboral $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>