<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class detalle_material
{
	public $id_detalle_material;
	public $descripcion;
	public $unidad_medida;
	public $cantidad_solicitada;
	public $cantidad_despachada;
	public $id_solicitud_material;
	private $bd;

	function detalle_material()
	{
		$this->bd = new conexion();
	}
	function registrar_detalle_material($descripcion, $unidad_medida, $cantidad_solicitada, $cantidad_despachada, $id_solicitud_material)
	{
		$registros = $this->bd->Consulta("insert into detalle_material values('$descripcion', '$unidad_medida', '$cantidad_solicitada', '$cantidad_despachada', '$id_solicitud_material'");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_detalle_material($id_detalle_material, $cantidad_solicitada)
	{
		$registros = $this->bd->Consulta("update detalle_material set cantidad_solicitada='$cantidad_solicitada' where id_detalle_material=$id_detalle_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_detalle_material)
	{
		$registros = $this->bd->Consulta("delete from detalle_material where id_detalle_material$id_detalle_material ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_detalle_material($id_detalle_material)
	{
		$registros = $this->bd->Consulta("select * from detalle_material where id_detalle_material=$id_detalle_material");
		$registro = $this->bd->getFila($registros);

		$this->id_detalle_material = $registro[id_detalle_material];
		$this->descripcion = $registro[descripcion];
		$this->unidad_medida = $registro[unidad_medida];
		$this->cantidad_solicitada = $registro[cantidad_solicitada];
		$this->cantidad_despachada = $registro[cantidad_despachada];
		$this->id_solicitud_material = $registro[id_solicitud_material];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from detalle_material $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>