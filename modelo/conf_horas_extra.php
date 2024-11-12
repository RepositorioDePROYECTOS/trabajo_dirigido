<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_horas_extra
{
	public $id_conf_horas_extra;
	public $tipo_he;
	public $factor_calculo;
	public $estado;
	private $bd;

	function conf_horas_extra()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_horas_extra($tipo_he, $factor_calculo, $estado)
	{
		$registros = $this->bd->Consulta("insert into conf_horas_extra values('','$tipo_he','$factor_calculo','$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_horas_extra($id_conf_horas_extra, $tipo_he, $factor_calculo, $estado)
	{
		$registros = $this->bd->Consulta("update conf_horas_extra set tipo_he='$tipo_he', factor_calculo='$factor_calculo', estado='$estado' where id_conf_horas_extra=$id_conf_horas_extra");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_horas_extra)
	{
		$registros = $this->bd->Consulta("delete from conf_horas_extra where id_conf_horas_extra=$id_conf_horas_extra");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_horas_extra($id_conf_horas_extra)
	{
		$registros = $this->bd->Consulta("select * from conf_horas_extra where id_conf_horas_extra=$id_conf_horas_extra");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_horas_extra = $registro[id_conf_horas_extra];
		$this->tipo_he = $registro[tipo_he];
		$this->factor_calculo = $registro[factor_calculo];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_horas_extra $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>