<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class especificacion_servicio
{
	public $id_especificaciones_servicio;
	public $especificacion;
	public $id_detalle_servicio;
	private $bd;

	function especificacion_servicio()
	{
		$this->bd = new conexion();
	}
	function registrar_especificacion_servicio($especificacion, $id_detalle_servicio)
	{
		$registros = $this->bd->Consulta("INSERT INTO especificaciones_servicio (especificacion, id_detalle_servicio) 
        values(
            '$especificacion',
            '$id_detalle_servicio')");
		if($this->bd->numFila_afectada()>0)
            return true;
        else
            return false;
	}
	function modificar_especificacion_servicio($id_especificaciones_servicio, $especificacion)
	{
		$registros = $this->bd->Consulta("UPDATE especificaciones_servicio set especificacion='$especificacion' where id_especificaciones_servicio=$id_especificaciones_servicio");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function eliminar($id_especificaciones_servicio)
	{
		$registros = $this->bd->Consulta("DELETE from especificaciones_servicio where id_especificaciones_servicio=$id_especificaciones_servicio ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>