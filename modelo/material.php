<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class vacacion
{
	public $id_material;
	public $descripcion;
	public $unidad_medida;
	public $cantidad;
	private $bd;

	function material()
	{
		$this->bd = new conexion();
	}
	function registrar_material($descripcion, $unidad_medida, $cantidad)
	{
		$registros = $this->bd->Consulta("insert into material values('','$descripcion', '$unidad_medida', '$cantidad'");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_material($id_material, $descripcion, $unidad_medida, $cantidad)
	{
		$registros = $this->bd->Consulta("update material set descripcion='$descripcion', unidad_medida='$unidad_medida', cantidad='$cantidad' where id_material=$id_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
		function eliminar($id_material)
	{
		$registros = $this->bd->Consulta("delete from material where id_material$id_material ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_material($id_material)
	{
		$registros = $this->bd->Consulta("select * from material where id_material=$id_material");
		$registro = $this->bd->getFila($registros);

		$this->id_material = $registro[id_material];
		$this->descripcion = $registro[descripcion];
		$this->unidad_medida = $registro[unidad_medida];
		$this->cantidad = $registro[cantidad];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from material $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>