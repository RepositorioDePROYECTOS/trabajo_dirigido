<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class otros_descuentos
{
	public $id_otros_descuentos;
	public $mes;
	public $gestion;
	public $descripcion;
	public $factor_calculo;
	public $monto_od;
	public $id_asignacion_cargo;
	private $bd;

	function otros_descuentos()
	{
		$this->bd = new conexion();
	}
	function registrar_otros_descuentos($mes, $gestion, $descripcion, $factor_calculo, $monto_od, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into otros_descuentos values('','$mes','$gestion', '$descripcion', '$factor_calculo', '$monto_od', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_otros_descuentos($id_otros_descuentos, $monto_od)
	{
		$registros = $this->bd->Consulta("update otros_descuentos set monto_od=$monto_od where id_otros_descuentos=$id_otros_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_otros_descuentos)
	{
		$registros = $this->bd->Consulta("delete from otros_descuentos where id_otros_descuentos=$id_otros_descuentos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from otros_descuentos where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_otros_descuentos($id_otros_descuentos)
	{
		$registros = $this->bd->Consulta("select * from otros_descuentos where id_otros_descuentos=$id_otros_descuentos");
		$registro = $this->bd->getFila($registros);

		$this->id_otros_descuentos = $registro[id_otros_descuentos];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->descripcion = $registro[descripcion];
		$this->factor_calculo = $registro[factor_calculo];
		$this->monto_od = $registro[monto_od];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from otros_descuentos $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>