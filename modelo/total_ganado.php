<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class total_ganado
{
	public $id_total_ganado;
	public $mes;
	public $gestion;
	public $total_dias;
	public $haber_mensual;
	public $haber_basico;
	public $bono_antiguedad;
	public $nro_horas_extra;
	public $monto_horas_extra;
	public $suplencia;
	public $total_ganado;
	public $id_asignacion_cargo;
	private $bd;

	function total_ganado()
	{
		$this->bd = new conexion();
	}
	function registrar_total_ganado($mes, $gestion, $total_dias, $haber_mensual, $haber_basico, $bono_antiguedad, $nro_horas_extra, $monto_horas_extra, $suplencia, $total_ganado, $id_asignacion_cargo)
	{
		$registros_b = $this->bd->Consulta("select * from total_ganado where mes = $mes and gestion = $gestion and id_asignacion_cargo = $id_asignacion_cargo");
		if($this->bd->numFila($registros_b) == 0)
		{
			$registros = $this->bd->Consulta("insert into total_ganado values('','$mes','$gestion', '$total_dias', '$haber_mensual', '$haber_basico', '$bono_antiguedad', '$nro_horas_extra', '$monto_horas_extra', '$suplencia', '$total_ganado', '$id_asignacion_cargo')");
			if($this->bd->numFila_afectada()>0)
				return true;
			else
				return false;
		}
	}
	function modificar_total_ganado($id_total_ganado, $total_dias, $haber_basico, $total_ganado)
	{
		$registros = $this->bd->Consulta("update total_ganado set total_dias= '$total_dias', haber_basico='$haber_basico', total_ganado='$total_ganado' where id_total_ganado=$id_total_ganado");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_total_ganado)
	{
		$registros = $this->bd->Consulta("delete from total_ganado where id_total_ganado=$id_total_ganado ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from total_ganado where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_total_ganado($id_total_ganado)
	{
		$registros = $this->bd->Consulta("select * from total_ganado where id_total_ganado=$id_total_ganado");
		$registro = $this->bd->getFila($registros);

		$this->id_total_ganado = $registro[id_total_ganado];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->total_dias = $registro[total_dias];
		$this->haber_mensual = $registro[haber_mensual];
		$this->haber_basico = $registro[haber_basico];
		$this->bono_antiguedad = $registro[bono_antiguedad];
		$this->nro_horas_extra = $registro[nro_horas_extra];
		$this->monto_horas_extra = $registro[monto_horas_extra];
		$this->suplencia = $registro[suplencia];
		$this->total_ganado = $registro[total_ganado];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from total_ganado $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>