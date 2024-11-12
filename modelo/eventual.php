<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class eventual
{
	public $id_eventual;
	public $nombres;
	public $apellido_paterno;
	public $apellido_materno;
	public $item;
	public $nivel;
	public $descripcion;
	public $seccion;
	public $salario_mensual;
	public $estado_eventual;
	private $bd;

	function eventual()
	{
		$this->bd = new conexion();
	}
	function registrar_eventual($nombres, $apellido_paterno, $apellido_materno, $item, $nivel, $descripcion, $seccion, $salario_mensual, $estado_eventual)
	{
		$registros = $this->bd->Consulta("insert into eventual values('', '$nombres', '$apellido_paterno', '$apellido_materno', '$item', '$nivel', '$descripcion', '$seccion', '$salario_mensual', '$estado_eventual')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_eventual($id_eventual, $nombres, $apellido_paterno, $apellido_materno, $item, $nivel, $descripcion, $seccion, $salario_mensual, $estado_eventual)
	{
		$registros = $this->bd->Consulta("update eventual set nombres='$nombres', apellido_paterno='$apellido_paterno',
			apellido_materno='$apellido_materno',  item='$item', nivel='$nivel', descripcion='$descripcion', seccion='$seccion', salario_mensual='$salario_mensual', estado_eventual='$estado_eventual' where id_eventual=$id_eventual");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function retirar_eventual($id_eventual)
	{
		$registros = $this->bd->Consulta("update eventual set estado_eventual='INHABILITADO' where id_eventual=$id_eventual");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_eventual)
	{
		$registros = $this->bd->Consulta("delete from eventual where id_eventual=$id_eventual");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_eventual($id_eventual)
	{
		$registros = $this->bd->Consulta("select * from eventual where id_eventual=$id_eventual");
		$registro = $this->bd->getFila($registros);

		$this->id_eventual = $registro[id_eventual];
		$this->nombres = $registro[nombres];
		$this->apellido_paterno = $registro[apellido_paterno];
		$this->apellido_materno = $registro[apellido_materno];
		$this->item = $registro[item];
		$this->nivel = $registro[nivel];
		$this->descripcion = $registro[descripcion];
		$this->seccion = $registro[seccion];
		$this->salario_mensual = $registro[salario_mensual];
		$this->estado_eventual = $registro[estado_eventual];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from eventual $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>