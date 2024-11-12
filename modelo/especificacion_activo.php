<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class especificacion_activo
{
	public $id_especificaciones_activo;
	public $especificacion;
	public $id_detalle_activo;
	private $bd;

	function especificacion_activo()
	{
		$this->bd = new conexion();
	}
	function registrar_especificacion_activo($especificacion, $id_detalle_activo)
	{
		$registros = $this->bd->Consulta("INSERT INTO especificaciones_activo (especificacion, id_detalle_activo) 
        values(
            '$especificacion',
            '$id_detalle_activo')");
		if($this->bd->numFila_afectada()>0)
            return true;
        else
            return false;
	}
	function modificar_especificacion_activo($id_especificaciones_activo, $especificacion)
	{
		$registros = $this->bd->Consulta("UPDATE especificaciones_activo set especificacion='$especificacion' where id_especificaciones_activo=$id_especificaciones_activo");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function eliminar($id_especificaciones_activo)
	{
		$registros = $this->bd->Consulta("DELETE from especificaciones_activo where id_especificaciones_activo=$id_especificaciones_activo ");
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