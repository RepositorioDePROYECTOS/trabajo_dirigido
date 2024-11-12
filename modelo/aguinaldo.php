<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class aguinaldo
{
	public $id_aguinaldo;
	public $gestion;
	public $meses;
	public $item;
	public $ci;
	public $nombre_empleado;
	public $dias;
	public $sexo;
	public $cargo;
	public $fecha_ingreso;
	public $sueldo_1;
	public $sueldo_2;
	public $sueldo_3;
	public $total;
	public $promedio_3_meses;
	public $aguinaldo_anual;
	public $aguinaldo_pagar;
	public $estado;
	public $nro_aguinaldo;
	public $id_asignacion_cargo;
	private $bd;

	function aguinaldo()
	{
		$this->bd = new conexion();
	}
	function registrar_aguinaldo($gestion, $meses, $item, $ci, $nombre_empleado, $dias, $sexo, $cargo, $fecha_ingreso, $sueldo_1, $sueldo_2, $sueldo_3, $total, $promedio_3_meses, $aguinaldo_anual, $aguinaldo_pagar, $estado, $nro_aguinaldo, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into aguinaldo values('','$gestion', '$meses', '$item', '$ci', '$nombre_empleado', '$dias', '$sexo', '$cargo', '$fecha_ingreso', '$sueldo_1', '$sueldo_2', '$sueldo_3', '$total', '$promedio_3_meses', '$aguinaldo_anual', '$aguinaldo_pagar', '$estado', '$nro_aguinaldo', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_aguinaldo($id_aguinaldo, $sueldo_1, $sueldo_2, $sueldo_3, $total, $promedio_3_meses, $aguinaldo_anual, $aguinaldo_pagar)
	{
		$registros = $this->bd->Consulta("update aguinaldo set sueldo_1='$sueldo_1', sueldo_2='$sueldo_2', sueldo_3='$sueldo_3', total='$total', promedio_3_meses='$promedio_3_meses', aguinaldo_anual='$aguinaldo_anual', aguinaldo_pagar='$aguinaldo_pagar' where id_aguinaldo=$id_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function aprobar_aguinaldo($id_aguinaldo)
	{
		$registros = $this->bd->Consulta("update aguinaldo set estado='APROBADO' where id_aguinaldo=$id_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function reprobar_aguinaldo($id_aguinaldo)
	{
		$registros = $this->bd->Consulta("update aguinaldo set estado='GENERADO' where id_aguinaldo=$id_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function deshabilitar_aguinaldo($id_aguinaldo)
	{
		$registros = $this->bd->Consulta("update aguinaldo set estado='RECHAZADO' where id_aguinaldo=$id_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_aguinaldo)
	{
		$registros = $this->bd->Consulta("delete from aguinaldo where id_aguinaldo=$id_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_aguinaldo($gestion, $nro_aguinaldo)
	{
		$registros = $this->bd->Consulta("delete from aguinaldo where gestion=$gestion and nro_aguinaldo=$nro_aguinaldo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_aguinaldo($id_aguinaldo)
	{
		$registros = $this->bd->Consulta("select * from aguinaldo where id_aguinaldo=$id_aguinaldo");
		$registro = $this->bd->getFila($registros);

		$this->id_aguinaldo = $registro[id_aguinaldo];
		$this->meses = $registro[meses];
		$this->gestion = $registro[gestion];
		$this->item = $registro[item];
		$this->ci = $registro[ci];
		$this->nombre_empleado = $registro[nombre_empleado];
		$this->dias = $registro[dias];
		$this->sexo = $registro[sexo];
		$this->cargo = $registro[cargo];
		$this->fecha_ingreso = $registro[fecha_ingreso];
		$this->sueldo_1 = $registro[sueldo_1];
		$this->sueldo_2 = $registro[sueldo_2];
		$this->sueldo_3 = $registro[sueldo_3];
		$this->total = $registro[total];
		$this->promedio_3_meses = $registro[promedio_3_meses];
		$this->aguinaldo_anual = $registro[aguinaldo_anual];
		$this->aguinaldo_pagar = $registro[aguinaldo_pagar];
		$this->estado = $registro[estado];
		$this->nro_aguinaldo = $registro[nro_aguinaldo];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from aguinaldo $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>