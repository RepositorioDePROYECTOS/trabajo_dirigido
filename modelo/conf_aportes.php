<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_aportes
{
	public $id_conf_aporte;
	public $tipo_aporte;
	public $rango_inicial;
	public $rango_final;
	public $porc_aporte;
	public $estado;
	private $bd;

	function conf_aportes()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_aportes($tipo_aporte, $rango_inicial, $rango_final, $porc_aporte, $estado)
	{
		$registros = $this->bd->Consulta("insert into conf_aportes values('','$tipo_aporte', '$rango_inicial', '$rango_final', '$porc_aporte','$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_aportes($id_conf_aporte, $tipo_aporte, $rango_inicial, $rango_final, $porc_aporte, $estado)
	{
		$registros = $this->bd->Consulta("update conf_aportes set tipo_aporte='$tipo_aporte', rango_inicial='$rango_inicial', rango_final='$rango_final', porc_aporte='$porc_aporte', estado='$estado' where id_conf_aporte=$id_conf_aporte");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_aporte)
	{
		$registros = $this->bd->Consulta("delete from conf_aportes where id_conf_aporte=$id_conf_aporte");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_aportes($id_conf_aporte)
	{
		$registros = $this->bd->Consulta("select * from conf_aportes where id_conf_aporte=$id_conf_aporte");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_aporte = $registro[id_conf_aporte];
		$this->tipo_aporte = $registro[tipo_aporte];
		$this->rango_inicial = $registro[rango_inicial];
		$this->rango_final = $registro[rango_final];
		$this->porc_aporte = $registro[porc_aporte];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_aportes $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>