<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class especificacion_material
{
	public $id_especificaciones_material;
	public $especificacion;
	public $id_detalle_material;
	private $bd;

	function especificacion_material()
	{
		$this->bd = new conexion();
	}
	function registrar_especificacion_material($especificacion, $id_detalle_material)
	{
		$registros = $this->bd->Consulta("INSERT INTO especificaciones_material (especificacion, id_detalle_material) 
        values(
            '$especificacion',
            '$id_detalle_material')");
		if($this->bd->numFila_afectada()>0)
            return true;
        else
            return false;
	}
	function modificar_especificacion_material($id_especificaciones_material, $especificacion)
	{
		$registros = $this->bd->Consulta("UPDATE especificaciones_material set especificacion='$especificacion' where id_especificaciones_material=$id_especificaciones_material");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function eliminar($id_especificaciones_material)
	{
		$registros = $this->bd->Consulta("DELETE from especificaciones_material where id_especificaciones_material=$id_especificaciones_material ");
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