<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class cargo
{
	public $id_cargo;
	public $item;
	public $nivel;
	public $seccion;
	public $descripcion;
	public $salario_mensual;
	public $estado_cargo;
	private $bd;

	function cargo()
	{
		$this->bd = new conexion();
	}
	function registrar_cargo($item, $nivel, $seccion, $descripcion, $salario_mensual, $estado_cargo)
	{
		$registros = $this->bd->Consulta("insert into cargo values('','$item','$nivel', '$seccion', '$descripcion', '$salario_mensual', '$estado_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_cargo($id_cargo, $item, $nivel, $seccion, $descripcion, $salario_mensual, $estado_cargo)
	{
		$registros = $this->bd->Consulta("update cargo set item='$item', nivel='$nivel', seccion='$seccion', descripcion='$descripcion', salario_mensual='$salario_mensual', estado_cargo='$estado_cargo' where id_cargo=$id_cargo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function liberar_cargo($id_cargo)
	{
		$registros = $this->bd->Consulta("update cargo set estado_cargo='LIBRE' where id_cargo=$id_cargo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function estado_cargo($id_cargo, $estado_cargo)
	{
		$registros = $this->bd->Consulta("update cargo set estado_cargo='$estado_cargo' where id_cargo=$id_cargo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_cargo)
	{
		$registros = $this->bd->Consulta("delete from cargo where id_cargo=$id_cargo ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_cargo($id_cargo)
	{
		$registros = $this->bd->Consulta("select * from cargo where id_cargo=$id_cargo");
		$registro = $this->bd->getFila($registros);

		$this->id_cargo = $registro[id_cargo];
		$this->item = $registro[item];
		$this->nivel = $registro[nivel];
		$this->seccion = $registro[seccion];
		$this->descripcion = $registro[descripcion];
		$this->salario_mensual = $registro[salario_mensual];
		$this->estado_cargo = $registro[estado_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from cargo $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>