<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_descuentos
{
	public $id_conf_descuentos;
	public $nombre_descuento;
	public $estado;
	private $bd;

	function conf_descuentos()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_descuentos($nombre_descuento, $estado)
	{
		$registros = $this->bd->Consulta("insert into conf_descuentos values('','$nombre_descuento', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_descuentos($id_conf_descuentos, $nombre_descuento, $estado)
	{
		$registros = $this->bd->Consulta("update conf_descuentos set nombre_descuento='$nombre_descuento', estado='$estado' where id_conf_descuentos=$id_conf_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_descuentos)
	{
		$registros = $this->bd->Consulta("delete from conf_descuentos where id_conf_descuentos=$id_conf_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_descuentos($id_conf_descuentos)
	{
		$registros = $this->bd->Consulta("select * from conf_descuentos where id_conf_descuentos=$id_conf_descuentos");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_descuentos = $registro[id_conf_descuentos];
		$this->nombre_descuento = $registro[nombre_descuento];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_descuentos $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>