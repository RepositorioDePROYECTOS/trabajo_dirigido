<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class vehiculo
{
	public $id_vehiculo;
	public $placa;
	public $marca;
	public $modelo;
	public $estado;
	private $bd;

	function vehiculo()
	{
		$this->bd = new Conexion();
	}
	function registrar_vehiculo($placa, $marca, $modelo, $estado)
	{
		$registros = $this->bd->Consulta("insert into vehiculo values('', '$placa', '$marca', '$modelo', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_vehiculo($id_vehiculo, $placa, $marca, $modelo)
	{
	   $registros = $this->bd->Consulta("update vehiculo set placa='$placa', marca='$marca', modelo='$modelo' where id_vehiculo=$id_vehiculo");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_vehiculo($id_vehiculo)
	{
		$registros = $this->bd->Consulta("select * from vehiculo where id_vehiculo=$id_vehiculo");
		$registro = $this->bd->getFila($registros);

		$this->id_vehiculo = $registro[id_vehiculo];
		$this->placa = $registro[placa];
		$this->marca = $registro[marca];
		$this->modelo = $registro[modelo];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from vehiculo $where");
			return $registros;
	}    
    function bloquear($id_vehiculo)
	{
		$registros = $this->bd->Consulta("update vehiculo set estado=0 where id_vehiculo=$id_vehiculo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_vehiculo)
	{
		$registros = $this->bd->Consulta("update vehiculo set estado=1 where id_vehiculo=$id_vehiculo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_vehiculo)
	{
		$registros = $this->bd->Consulta("delete from vehiculo where id_vehiculo=$id_vehiculo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function __destroy()
	{
		$vehiculo = $this->bd->Cerrar();
	}
}
 
?>