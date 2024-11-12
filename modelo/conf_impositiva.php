<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_impositiva
{
	public $id_conf_impositiva;
	public $salario_minimo;
	public $cant_sm;
	public $porcentaje_imp;
	public $estado;
	private $bd;

	function conf_impositiva()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_impositiva($salario_minimo, $cant_sm, $porcentaje_imp, $estado)
	{
		$registros = $this->bd->Consulta("insert into conf_impositiva values('','$salario_minimo', '$cant_sm', '$porcentaje_imp', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_impositiva($id_conf_impositiva, $salario_minimo, $cant_sm, $porcentaje_imp, $estado)
	{
		$registros = $this->bd->Consulta("update conf_impositiva set salario_minimo='$salario_minimo', cant_sm='$cant_sm', porcentaje_imp='$porcentaje_imp', estado='$estado' where id_conf_impositiva=$id_conf_impositiva");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_impositiva)
	{
		$registros = $this->bd->Consulta("delete from conf_impositiva where id_conf_impositiva=$id_conf_impositiva");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_impositiva($id_conf_impositiva)
	{
		$registros = $this->bd->Consulta("select * from conf_impositiva where id_conf_impositiva=$id_conf_impositiva");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_impositiva = $registro[id_conf_impositiva];
		$this->salario_minimo = $registro[salario_minimo];
		$this->cant_sm = $registro[cant_sm];
		$this->porcentaje_imp = $registro[porcentaje_imp];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_impositiva $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>