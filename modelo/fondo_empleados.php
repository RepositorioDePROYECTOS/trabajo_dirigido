<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class fondo_empleados
{
	public $id_fondo_empleados;
	public $mes;
	public $gestion;
	public $porcentaje_fe;
	public $total_ganado;
	public $monto_fe;
	public $pago_deuda;
	public $total_fe;
	public $id_asignacion_cargo;
	private $bd;

	function fondo_empleados()
	{
		$this->bd = new conexion();
	}
	function registrar_fondo_empleados($mes, $gestion, $porcentaje_fe, $total_ganado, $monto_fe, $pago_deuda, $total_fe, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into fondo_empleados values('', '$mes', '$gestion', '$porcentaje_fe', '$total_ganado', '$monto_fe', '$pago_deuda', '$total_fe', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_fondo_empleados($id_fondo_empleados, $pago_deuda, $monto_fe, $total_fe)
	{
		$registros = $this->bd->Consulta("update fondo_empleados set pago_deuda='$pago_deuda', monto_fe='$monto_fe', total_fe='$total_fe' where id_fondo_empleados=$id_fondo_empleados");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_fondo_empleados)
	{
		$registros = $this->bd->Consulta("delete from fondo_empleados where id_fondo_empleados=$id_fondo_empleados ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from fondo_empleados where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_fondo_empleados($id_fondo_empleados)
	{
		$registros = $this->bd->Consulta("select * from fondo_empleados where id_fondo_empleados=$id_fondo_empleados");
		$registro = $this->bd->getFila($registros);

		$this->id_fondo_empleados = $registro[id_fondo_empleados];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->porcentaje_fe = $registro[porcentaje_fe];
		$this->total_ganado = $registro[total_ganado];
		$this->monto_fe = $registro[monto_fe];
		$this->pago_deuda = $registro[pago_deuda];
		$this->total_fe = $registro[total_fe];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from fondo_empleados $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>