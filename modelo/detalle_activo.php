<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class detalle_activo
{
	public $id_detalle_activo;
	public $descripcion;
	public $unidad_medida;
	public $cantidad_solicitada;
	public $cantidad_despachada;
	public $id_solicitud_activo;
	private $bd;

	function detalle_activo()
	{
		$this->bd = new conexion();
	}
	function registrar_detalle_activo($descripcion, $unidad_medida, $cantidad_solicitada, $cantidad_despachada, $id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("insert into detalle_activo values('$descripcion', '$unidad_medida', '$cantidad_solicitada', '$cantidad_despachada', '$id_solicitud_activo'");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_detalle_activo($id_detalle_activo, $cantidad_solicitada)
	{
		$registros = $this->bd->Consulta("update detalle_activo set cantidad_solicitada='$cantidad_solicitada' where id_detalle_activo=$id_detalle_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_detalle_activo)
	{
		$registros = $this->bd->Consulta("delete from detalle_activo where id_detalle_activo$id_detalle_activo ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_detalle_activo($id_detalle_activo)
	{
		$registros = $this->bd->Consulta("select * from detalle_activo where id_detalle_activo=$id_detalle_activo");
		$registro = $this->bd->getFila($registros);

		$this->id_detalle_activo = $registro[id_detalle_activo];
		$this->descripcion = $registro[descripcion];
		$this->unidad_medida = $registro[unidad_medida];
		$this->cantidad_solicitada = $registro[cantidad_solicitada];
		$this->cantidad_despachada = $registro[cantidad_despachada];
		$this->id_solicitud_activo = $registro[id_solicitud_activo];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from detalle_activo $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>