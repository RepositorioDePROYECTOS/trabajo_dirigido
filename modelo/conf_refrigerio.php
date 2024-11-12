<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_refrigerio
{
	public $id_conf_refrigerio;
	public $descripcion;
	public $monto_refrigerio;
	public $estado_refrigerio;
	private $bd;

	function conf_refrigerio()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_refrigerio($descripcion, $monto_refrigerio, $estado_refrigerio)
	{
		$registros = $this->bd->Consulta("insert into conf_refrigerio values('','$descripcion', '$monto_refrigerio', '$estado_refrigerio')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_refrigerio($id_conf_refrigerio, $descripcion, $monto_refrigerio, $estado_refrigerio)
	{
		$registros = $this->bd->Consulta("update conf_refrigerio set descripcion='$descripcion', monto_refrigerio='$monto_refrigerio', estado_refrigerio='$estado_refrigerio' where id_conf_refrigerio=$id_conf_refrigerio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_refrigerio)
	{
		$registros = $this->bd->Consulta("delete from conf_refrigerio where id_conf_refrigerio=$id_conf_refrigerio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_refrigerio($id_conf_refrigerio)
	{
		$registros = $this->bd->Consulta("select * from conf_refrigerio where id_conf_refrigerio=$id_conf_refrigerio");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_refrigerio = $registro[id_conf_refrigerio];
		$this->descripcion = $registro[descripcion];
		$this->monto_refrigerio = $registro[monto_refrigerio];
		$this->estado_refrigerio = $registro[estado_refrigerio];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_refrigerio $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>