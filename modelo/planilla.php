<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class planilla
{
	public $id_planilla;
	public $mes;
	public $gestion;
	public $item;
	public $ci;
	public $nua;
	public $nombres;
	public $apellidos;
	public $cargo;
	public $fecha_ingreso;
	public $dias_pagado;
	public $haber_mensual;
	public $haber_basico;
	public $bono_antiguedad;
	public $horas_extra;
	public $suplencia;
	public $total_ganado;
	public $sindicato;
	public $categoria_individual;
	public $prima_riesgo_comun;
	public $comision_ente;
	public $total_aporte_solidario;
	public $desc_rciva;
	public $otros_descuentos;
	public $fondo_social;
	public $fondo_empleados;
	public $entidades_financieras;
	public $total_descuentos;
	public $liquido_pagable;
	public $estado_planilla;
	public $fecha_aprobado;
	public $id_nombre_planilla;
	private $bd;

	function planilla()
	{
		$this->bd = new conexion();
	}
	function registrar_planilla($mes, $gestion, $item, $ci, $nua, $nombres, $apellidos, $cargo, $fecha_ingreso, $dias_pagado, $haber_mensual, $haber_basico, $bono_antiguedad, $horas_extra, $suplencia, $total_ganado, $sindicato, $categoria_individual, $prima_riesgo_comun, $comision_ente, $total_aporte_solidario, $desc_rciva, $otros_descuentos, $fondo_social, $fondo_empleados, $entidades_financieras, $total_descuentos, $liquido_pagable, $estado_planilla, $fecha_aprobado, $id_nombre_planilla)
	{
		$registros = $this->bd->Consulta("insert into planilla values('','$mes', '$gestion', '$item', '$ci', '$nua', '$nombres', '$apellidos', '$cargo', '$fecha_ingreso', '$dias_pagado', '$haber_mensual', '$haber_basico', '$bono_antiguedad', '$horas_extra', '$suplencia', '$total_ganado', '$sindicato', '$categoria_individual', '$prima_riesgo_comun', '$comision_ente', '$total_aporte_solidario', '$desc_rciva', '$otros_descuentos', '$fondo_social', '$fondo_empleados', '$entidades_financieras', '$total_descuentos', '$liquido_pagable', '$estado_planilla', '$fecha_aprobado', '$id_nombre_planilla')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function aprobar_planilla($id_planilla)
	{
		$fecha_aprobado = date('Y-m-d');
		$registros = $this->bd->Consulta("update planilla set estado_planilla='APROBADO', fecha_aprobado='$fecha_aprobado' where id_planilla=$id_planilla");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function reprobar_planilla($id_planilla)
	{
		$fecha_aprobado = date('Y-m-d');
		$registros = $this->bd->Consulta("update planilla set estado_planilla='GENERADO', fecha_aprobado='$fecha_aprobado' where id_planilla=$id_planilla");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function deshabilitar_planilla($id_planilla)
	{
		$registros = $this->bd->Consulta("update planilla set estado_planilla='RECHAZADO' where id_planilla=$id_planilla");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_planilla)
	{
		$registros = $this->bd->Consulta("delete from planilla where id_planilla=$id_planilla ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($id_nombre_planilla)
	{
		$registros = $this->bd->Consulta("delete from planilla where id_nombre_planilla=$id_nombre_planilla");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_planilla($id_planilla)
	{
		$registros = $this->bd->Consulta("select * from planilla where id_planilla=$id_planilla");
		$registro = $this->bd->getFila($registros);

		$this->id_planilla = $registro[id_planilla];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->item = $registro[item];
		$this->ci = $registro[ci];
		$this->nua = $registro[nua];
		$this->nombres = $registro[nombres];
		$this->apellidos = $registro[apellidos];
		$this->cargo = $registro[cargo];
		$this->fecha_ingreso = $registro[fecha_ingreso];
		$this->dias_pagado = $registro[dias_pagado];
		$this->haber_mensual = $registro[haber_mensual];
		$this->haber_basico = $registro[haber_basico];
		$this->bono_antiguedad = $registro[bono_antiguedad];
		$this->horas_extra = $registro[horas_extra];
		$this->suplencia = $registro[suplencia];
		$this->total_ganado = $registro[total_ganado];
		$this->sindicato = $registro[sindicato];
		$this->categoria_individual = $registro[categoria_individual];
		$this->prima_riesgo_comun = $registro[prima_riesgo_comun];
		$this->comision_ente = $registro[comision_ente];
		$this->total_aporte_solidario = $registro[total_aporte_solidario];
		$this->desc_rciva = $registro[desc_rciva];
		$this->otros_descuentos = $registro[otros_descuentos];
		$this->fondo_social = $registro[fondo_social];
		$this->fondo_empleados = $registro[fondo_empleados];
		$this->entidades_financieras = $registro[entidades_financieras];
		$this->total_descuentos = $registro[total_descuentos];
		$this->liquido_pagable = $registro[liquido_pagable];
		$this->estado_planilla = $registro[estado_planilla];
		$this->fecha_aprobado = $registro[fecha_aprobado];
		$this->id_nombre_planilla = $registro[id_nombre_planilla];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from planilla $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>