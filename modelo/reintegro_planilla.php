<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class reintegro_planilla
{
	public $id_planilla_reintegro;
	public $mes_reintegro;
	public $gestion_reintegro;
	public $item_reintegro;
	public $ci_reintegro;
	public $nua_reintegro;
	public $nombres_reintegro;
	public $apellidos_reintegro;
	public $cargo_reintegro;
	public $fecha_ingreso_reintegro;
	public $dias_pagado_reintegro;
	public $haber_mensual_reintegro;
	public $haber_basico_reintegro;
	public $bono_antiguedad_reintegro;
	public $horas_extra_reintegro;
	public $suplencia_reintegro;
	public $total_ganado_reintegro;
	public $sindicato_reintegro;
	public $categoria_individual_reintegro;
	public $prima_riesgo_comun_reintegro;
	public $comision_ente_reintegro;
	public $total_aporte_solidario_reintegro;
	public $desc_rciva_reintegro;
	public $otros_descuentos_reintegro;
	public $fondo_social_reintegro;
	public $fondo_empleados_reintegro;
	public $entidades_financieras_reintegro;
	public $total_descuentos_reintegro;
	public $liquido_pagable_reintegro;
	public $estado_planilla_reintegro;
	public $fecha_aprobado_reintegro;
	public $id_planilla;
	private $bd;

	function reintegro_planilla()
	{
		$this->bd = new conexion();
	}
	function registrar_reintegro_planilla($mes_reintegro, $gestion_reintegro, $item_reintegro, $ci_reintegro, $nua_reintegro, $nombres_reintegro, $apellidos_reintegro, $cargo_reintegro, $fecha_ingreso_reintegro, $dias_pagado_reintegro, $haber_mensual_reintegro, $haber_basico_reintegro, $bono_antiguedad_reintegro, $horas_extra_reintegro, $suplencia_reintegro, $total_ganado_reintegro, $sindicato_reintegro, $categoria_individual_reintegro, $prima_riesgo_comun_reintegro, $comision_ente_reintegro, $total_aporte_solidario_reintegro, $desc_rciva_reintegro, $otros_descuentos_reintegro, $fondo_social_reintegro, $fondo_empleados_reintegro, $entidades_financieras_reintegro, $total_descuentos_reintegro, $liquido_pagable_reintegro, $estado_planilla_reintegro, $fecha_aprobado_reintegro, $id_planilla)
	{
		$registros = $this->bd->Consulta("insert into reintegro_planilla values('','$mes_reintegro', '$gestion_reintegro', '$item_reintegro', '$ci_reintegro', '$nua_reintegro', '$nombres_reintegro', '$apellidos_reintegro', '$cargo_reintegro', '$fecha_ingreso_reintegro', '$dias_pagado_reintegro', '$haber_mensual_reintegro', '$haber_basico_reintegro', '$bono_antiguedad_reintegro', '$horas_extra_reintegro', '$suplencia_reintegro', '$total_ganado_reintegro', '$sindicato_reintegro', '$categoria_individual_reintegro', '$prima_riesgo_comun_reintegro', '$comision_ente_reintegro', '$total_aporte_solidario_reintegro', '$desc_rciva_reintegro', '$otros_descuentos_reintegro', '$fondo_social_reintegro', '$fondo_empleados_reintegro', '$entidades_financieras_reintegro', '$total_descuentos_reintegro', '$liquido_pagable_reintegro', '$estado_planilla_reintegro', '$fecha_aprobado_reintegro', '$id_planilla')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function aprobar_reintegro_planilla($id_planilla_reintegro)
	{
		$fecha_aprobado_reintegro = date('Y-m-d');
		$registros = $this->bd->Consulta("update reintegro_planilla set estado_planilla_reintegro='APROBADO', fecha_aprobado_reintegro='$fecha_aprobado_reintegro' where id_planilla_reintegro=$id_planilla_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function reprobar_reintegro_planilla($id_planilla_reintegro)
	{
		$fecha_aprobado_reintegro = date('Y-m-d');
		$registros = $this->bd->Consulta("update reintegro_planilla set estado_planilla_reintegro='GENERADO', fecha_aprobado_reintegro='$fecha_aprobado_reintegro' where id_planilla_reintegro=$id_planilla_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function deshabilitar_reintegro_planilla($id_planilla_reintegro)
	{
		$registros = $this->bd->Consulta("update reintegro_planilla set estado_planilla_reintegro='RECHAZADO' where id_planilla_reintegro=$id_planilla_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_planilla_reintegro)
	{
		$registros = $this->bd->Consulta("delete from reintegro_planilla where id_planilla_reintegro=$id_planilla_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_reintegro_planilla($gestion, $mes)
	{
		$registros = $this->bd->Consulta("delete from reintegro_planilla where mes_reintegro=$mes and gestion_reintegro=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_reintegro_planilla($id_planilla_reintegro)
	{
		$registros = $this->bd->Consulta("select * from reintegro_planilla where id_planilla_reintegro=$id_planilla_reintegro");
		$registro = $this->bd->getFila($registros);

		$this->id_planilla_reintegro = $registro[id_planilla_reintegro];
		$this->mes_reintegro = $registro[mes_reintegro];
		$this->gestion_reintegro = $registro[gestion_reintegro];
		$this->item_reintegro = $registro[item_reintegro];
		$this->ci_reintegro = $registro[ci_reintegro];
		$this->nua_reintegro = $registro[nua_reintegro];
		$this->nombres_reintegro = $registro[nombres_reintegro];
		$this->apellidos_reintegro = $registro[apellidos_reintegro];
		$this->cargo_reintegro = $registro[cargo_reintegro];
		$this->fecha_ingreso_reintegro = $registro[fecha_ingreso_reintegro];
		$this->dias_pagado_reintegro = $registro[dias_pagado_reintegro];
		$this->haber_mensual_reintegro = $registro[haber_mensual_reintegro];
		$this->haber_basico_reintegro = $registro[haber_basico_reintegro];
		$this->bono_antiguedad_reintegro = $registro[bono_antiguedad_reintegro];
		$this->horas_extra_reintegro = $registro[horas_extra_reintegro];
		$this->suplencia_reintegro = $registro[suplencia_reintegro];
		$this->total_ganado_reintegro = $registro[total_ganado_reintegro];
		$this->sindicato_reintegro = $registro[sindicato_reintegro];
		$this->categoria_individual_reintegro = $registro[categoria_individual_reintegro];
		$this->prima_riesgo_comun_reintegro = $registro[prima_riesgo_comun_reintegro];
		$this->comision_ente_reintegro = $registro[comision_ente_reintegro];
		$this->total_aporte_solidario_reintegro = $registro[total_aporte_solidario_reintegro];
		$this->desc_rciva_reintegro = $registro[desc_rciva_reintegro];
		$this->otros_descuentos_reintegro = $registro[otros_descuentos_reintegro];
		$this->fondo_social_reintegro = $registro[fondo_social_reintegro];
		$this->fondo_empleados_reintegro = $registro[fondo_empleados_reintegro];
		$this->entidades_financieras_reintegro = $registro[entidades_financieras_reintegro];
		$this->total_descuentos_reintegro = $registro[total_descuentos_reintegro];
		$this->liquido_pagable_reintegro = $registro[liquido_pagable_reintegro];
		$this->estado_planilla_reintegro = $registro[estado_planilla_reintegro];
		$this->fecha_aprobado_reintegro = $registro[fecha_aprobado_reintegro];
		$this->id_planilla = $registro[id_planilla];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from reintegro_planilla $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>