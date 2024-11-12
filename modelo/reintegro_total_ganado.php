<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class reintegro_total_ganado
{
	public $id_total_ganado_reintegro;
	public $mes_reintegro;
	public $gestion_reintegro;
	public $total_dias_reintegro;
	public $haber_mensual_reintegro;
	public $haber_basico_reintegro;
	public $bono_antiguedad_reintegro;
	public $nro_horas_extra_reintegro;
	public $monto_horas_extra_reintegro;
	public $suplencia_reintegro;
	public $total_ganado_reintegro;
	public $id_total_ganado;
	private $bd;

	function reintegro_total_ganado()
	{
		$this->bd = new conexion();
	}
	function registrar_reintegro_total_ganado($mes_reintegro, $gestion_reintegro, $total_dias_reintegro, $haber_mensual_reintegro, $haber_basico_reintegro, $bono_antiguedad_reintegro, $nro_horas_extra_reintegro, $monto_horas_extra_reintegro, $suplencia_reintegro, $total_ganado_reintegro, $id_total_ganado)
	{
		$registros_b = $this->bd->Consulta("select * from reintegro_total_ganado where mes_reintegro = $mes_reintegro and gestion_reintegro = $gestion_reintegro and id_total_ganado = $id_total_ganado");
		if($this->bd->numFila($registros_b) == 0)
		{
			$registros = $this->bd->Consulta("insert into reintegro_total_ganado values('','$mes_reintegro','$gestion_reintegro', '$total_dias_reintegro', '$haber_mensual_reintegro', '$haber_basico_reintegro', '$bono_antiguedad_reintegro', '$nro_horas_extra_reintegro', '$monto_horas_extra_reintegro', '$suplencia_reintegro', '$total_ganado_reintegro', '$id_total_ganado')");
			if($this->bd->numFila_afectada()>0)
				return true;
			else
				return false;
		}
	}
	function modificar_reintegro_total_ganado($id_total_ganado_reintegro, $total_dias_reintegro, $haber_basico_reintegro, $total_ganado_reintegro, $bono_antiguedad_reintegro)
	{
		$registros = $this->bd->Consulta("update reintegro_total_ganado set total_dias_reintegro= '$total_dias_reintegro', haber_basico_reintegro='$haber_basico_reintegro', total_ganado_reintegro='$total_ganado_reintegro', bono_antiguedad_reintegro='$bono_antiguedad_reintegro' where id_total_ganado_reintegro=$id_total_ganado_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_reintegro_total_ganado)
	{
		$registros = $this->bd->Consulta("delete from reintegro_total_ganado where id_total_ganado_reintegro=$id_total_ganado_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes_reintegro, $gestion_reintegro)
	{
		$registros = $this->bd->Consulta("delete from reintegro_total_ganado where mes_reintegro=$mes_reintegro and gestion_reintegro=$gestion_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_reintegro_total_ganado($id_total_ganado_reintegro)
	{
		$registros = $this->bd->Consulta("select * from reintegro_total_ganado where id_total_ganado_reintegro=$id_total_ganado_reintegro");
		$registro = $this->bd->getFila($registros);

		$this->id_total_ganado_reintegro = $registro[id_total_ganado_reintegro];
		$this->mes_reintegro = $registro[mes_reintegro];
		$this->gestion_reintegro = $registro[gestion_reintegro];
		$this->total_dias_reintegro = $registro[total_dias_reintegro];
		$this->haber_mensual_reintegro = $registro[haber_mensual_reintegro];
		$this->haber_basico_reintegro = $registro[haber_basico_reintegro];
		$this->bono_antiguedad_reintegro = $registro[bono_antiguedad_reintegro];
		$this->nro_horas_extra_reintegro = $registro[nro_horas_extra_reintegro];
		$this->monto_horas_extra_reintegro = $registro[monto_horas_extra_reintegro];
		$this->suplencia_reintegro = $registro[suplencia_reintegro];
		$this->total_ganado_reintegro = $registro[total_ganado_reintegro];
		$this->id_total_ganado = $registro[id_total_ganado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from reintegro_total_ganado $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>