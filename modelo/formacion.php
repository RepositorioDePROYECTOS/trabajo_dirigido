<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class formacion
{
	public $id_formacion;
	public $grado_formacion;
	public $titulo_academico;
	public $id_trabajador;
	private $bd;

	function formacion()
	{
		$this->bd = new conexion();
	}
	function registrar_formacion($grado_formacion, $titulo_academico, $id_trabajador)
	{
		$registros = $this->bd->Consulta("insert into formacion values('', '$grado_formacion', '$titulo_academico', '$id_trabajador')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_formacion($id_formacion, $grado_formacion, $titulo_academico, $id_trabajadorr)
	{
		$registros = $this->bd->Consulta("update formacion set grado_formacion='$grado_formacion', titulo_academico='$titulo_academico', id_trabajador='$id_trabajador' where id_formacionr=$id_formacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function eliminar($id_formacion)
	{
		$registros = $this->bd->Consulta("delete from formacion where id_formacion=$id_formacion ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_formacion($id_formacion)
	{
		$registros = $this->bd->Consulta("select * from formacion where id_formacion=$id_formacion");
		$registro = $this->bd->getFila($registros);

		$this->id_formacion = $registro[id_formacion];
		$this->grado_formacion = $registro[grado_formacion];
		$this->titulo_academico = $registro[titulo_academico];
		$this->id_trabajador = $registro[id_trabajador];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from formacion $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>