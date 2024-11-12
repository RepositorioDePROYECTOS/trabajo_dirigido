<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class impositiva
{
	public $id_impositiva;
	public $mes;
	public $gestion;
	public $ufv_actual;
	public $ufv_pasado;
	public $total_ganado;
	public $aportes_laborales;
	public $sueldo_neto;
	public $minimo_no_imponible;
	public $base_imponible;
	public $impuesto_bi;
	public $presentacion_desc;
	public $impuesto_mn;
	public $saldo_dependiente;
	public $saldo_fisco;
	public $saldo_mes_anterior;
	public $actualizacion;
	public $saldo_total_mes_anterior;
	public $saldo_total_dependiente;
	public $saldo_utilizado;
	public $retencion_pagar;
	public $saldo_siguiente_mes;
	public $id_asignacion_cargo;
	private $bd;

	function impositiva()
	{
		$this->bd = new conexion();
	}
	function registrar_impositiva($mes, $gestion, $ufv_actual, $ufv_pasado, $total_ganado, $aportes_laborales, $sueldo_neto, $minimo_no_imponible, $base_imponible, $impuesto_bi, $presentacion_desc, $impuesto_mn, $saldo_dependiente, $saldo_fisco, $saldo_mes_anterior, $actualizacion, $saldo_total_mes_anterior, $saldo_total_dependiente, $saldo_utilizado, $retencion_pagar, $saldo_siguiente_mes, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("insert into impositiva values('','$mes', '$gestion', '$ufv_actual', '$ufv_pasado', '$total_ganado', '$aportes_laborales', '$sueldo_neto', '$minimo_no_imponible', '$base_imponible', '$impuesto_bi', '$presentacion_desc', '$impuesto_mn', '$saldo_dependiente', '$saldo_fisco', '$saldo_mes_anterior', '$actualizacion', '$saldo_total_mes_anterior', '$saldo_total_dependiente', '$saldo_utilizado', '$retencion_pagar', '$saldo_siguiente_mes', '$id_asignacion_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_impositiva($id_impositiva, $mes, $gestion, $ufv_actual, $ufv_pasado, $total_ganado, $aportes_laborales, $sueldo_neto, $minimo_no_imponible, $base_imponible, $impuesto_bi, $presentacion_desc, $impuesto_mn, $saldo_dependiente, $saldo_fisco, $saldo_mes_anterior, $actualizacion, $saldo_total_mes_anterior, $saldo_total_dependiente, $saldo_utilizado, $retencion_pagar, $saldo_siguiente_mes, $id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("update impositiva set mes='$mes', gestion='$gestion', ufv_actual='$ufv_actual', ufv_pasado='$ufv_pasado', total_ganado='$total_ganado', aportes_laborales='$aportes_laborales', sueldo_neto='$sueldo_neto', minimo_no_imponible='$minimo_no_imponible', base_imponible='$base_imponible', impuesto_bi='$impuesto_bi', presentacion_desc='$presentacion_desc', impuesto_mn='$impuesto_mn', saldo_dependiente='$saldo_dependiente', saldo_fisco='$saldo_fisco', saldo_mes_anterior='$saldo_mes_anterior', actualizacion='$actualizacion', saldo_total_mes_anterior='$saldo_total_mes_anterior', saldo_total_dependiente='$saldo_total_dependiente', saldo_utilizado='$saldo_utilizado', retencion_pagar='$retencion_pagar', saldo_siguiente_mes='$saldo_siguiente_mes', id_asignacion_cargo='$id_asignacion_cargo' where id_impositiva=$id_impositiva");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_impositiva)
	{
		$registros = $this->bd->Consulta("delete from impositiva where id_impositiva=$id_impositiva ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from impositiva where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_impositiva($id_impositiva)
	{
		$registros = $this->bd->Consulta("select * from impositiva where id_impositiva=$id_impositiva");
		$registro = $this->bd->getFila($registros);

		$this->id_impositiva = $registro[id_impositiva];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->ufv_actual = $registro[ufv_actual];
		$this->ufv_pasado = $registro[ufv_pasado];
		$this->total_ganado = $registro[total_ganado];
		$this->aportes_laborales = $registro[aportes_laborales];
		$this->sueldo_neto = $registro[sueldo_neto];
		$this->minimo_no_imponible = $registro[minimo_no_imponible];
		$this->base_imponible = $registro[base_imponible];
		$this->impuesto_bi = $registro[impuesto_bi];
		$this->presentacion_desc = $registro[presentacion_desc];
		$this->impuesto_mn = $registro[impuesto_mn];
		$this->saldo_dependiente = $registro[saldo_dependiente];
		$this->saldo_fisco = $registro[saldo_fisco];
		$this->saldo_mes_anterior = $registro[saldo_mes_anterior];
		$this->actualizacion = $registro[actualizacion];
		$this->saldo_total_mes_anterior = $registro[saldo_total_mes_anterior];
		$this->saldo_total_dependiente = $registro[saldo_total_dependiente];
		$this->saldo_utilizado = $registro[saldo_utilizado];
		$this->retencion_pagar = $registro[retencion_pagar];
		$this->saldo_siguiente_mes = $registro[saldo_siguiente_mes];
		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from impositiva $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>