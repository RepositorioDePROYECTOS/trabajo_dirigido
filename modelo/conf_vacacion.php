<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_vacacion
{
	public $id_conf_vacacion;
	public $anio_inicio;
	public $anio_fin;
	public $dias_vacacion;
	public $estado_vaca;
	private $bd;

	function conf_vacacion()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_vacacion($anio_inicio, $anio_fin, $dias_vacacion, $estado_vaca)
	{
		$registros = $this->bd->Consulta("insert into conf_vacacion values('','$anio_inicio', '$anio_fin', '$dias_vacacion', '$estado_vaca')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_vacacion($id_conf_vacacion, $anio_inicio, $anio_fin, $dias_vacacion, $estado_vaca)
	{
		$registros = $this->bd->Consulta("update conf_vacacion set anio_inicio='$anio_inicio', anio_fin='$anio_fin', dias_vacacion='$dias_vacacion', estado_vaca='$estado_vaca' where id_conf_vacacion=$id_conf_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_vacacion)
	{
		$registros = $this->bd->Consulta("delete from conf_vacacion where id_conf_vacacion=$id_conf_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_vacacion($id_conf_vacacion)
	{
		$registros = $this->bd->Consulta("select * from conf_vacacion where id_conf_vacacion=$id_conf_vacacion");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_vacacion = $registro[id_conf_vacacion];
		$this->anio_inicio = $registro[anio_inicio];
		$this->anio_fin = $registro[anio_fin];
		$this->dias_vacacion = $registro[dias_vacacion];
		$this->estado_vaca = $registro[estado_vaca];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_vacacion $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>