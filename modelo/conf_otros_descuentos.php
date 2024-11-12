<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_otros_descuentos
{
	public $id_conf_otros_descuentos;
	public $descripcion;
	public $factor_calculo;
	public $estado;
	private $bd;

	function conf_otros_descuentos()
	{
		$this->bd = new conexion();
	}
	
	function registrar_conf_otros_descuentos($descripcion, $factor_calculo, $estado)
	{
		$registros = $this->bd->Consulta("insert into conf_otros_descuentos values('','$descripcion', '$factor_calculo','$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_otros_descuentos($id_conf_otros_descuentos, $descripcion, $factor_calculo, $estado)
	{
		$registros = $this->bd->Consulta("update conf_otros_descuentos set descripcion='$descripcion', factor_calculo='$factor_calculo', estado='$estado' where id_conf_otros_descuentos=$id_conf_otros_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_otros_descuentos)
	{
		$registros = $this->bd->Consulta("delete from conf_otros_descuentos where id_conf_otros_descuentos=$id_conf_otros_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_otros_descuentos($id_conf_otros_descuentos)
	{
		$registros = $this->bd->Consulta("select * from conf_otros_descuentos where id_conf_otros_descuentos=$id_conf_otros_descuentos");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_otros_descuentos = $registro[id_conf_otros_descuentos];
		$this->descripcion = $registro[descripcion];
		$this->factor_calculo = $registro[factor_calculo];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_otros_descuentos $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>