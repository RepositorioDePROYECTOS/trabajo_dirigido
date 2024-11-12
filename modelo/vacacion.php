<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class vacacion
{
	public $id_vacacion;
	public $fecha_ingreso;
	public $anios_empresa;
	public $meses_empresa;
	public $dias_empresa;
	public $dias_vacacion;
	public $vacacion_acumulada;
	public $fecha_calculo;
	public $id_trabajador;
	private $bd;

	function vacacion()
	{
		$this->bd = new conexion();
	}
	function registrar_vacacion($fecha_ingreso, $anios_empresa, $meses_empresa, $dias_empresa, $dias_vacacion, $vacacion_acumulada, $fecha_calculo, $id_trabajador)
	{
		$registros = $this->bd->Consulta("insert into vacacion values('','$fecha_ingreso', '$anios_empresa', '$meses_empresa', '$dias_empresa', '$dias_vacacion', '$vacacion_acumulada', '$fecha_calculo', '$id_trabajador')");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_vacacion($id_vacacion, $fecha_ingreso, $anios_empresa, $meses_empresa, $dias_empresa, $dias_vacacion, $fecha_calculo ,$id_trabajador)
	{
		$registros = $this->bd->Consulta("update vacacion set fecha_ingreso='$fecha_ingreso', anios_empresa='$anios_empresa', meses_empresa='$meses_empresa', dias_empresa='$dias_empresa',  dias_vacacion='$dias_vacacion', fecha_calculo='$fecha_calculo', id_trabajador='$id_trabajador' where id_vacacion=$id_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function actualizar_vacacion($id_vacacion, $anios_empresa, $meses_empresa, $dias_empresa, $dias_vacacion, $fecha_calculo)
	{
		$registros = $this->bd->Consulta("update vacacion set  anios_empresa='$anios_empresa', meses_empresa='$meses_empresa', dias_empresa='$dias_empresa',  dias_vacacion='$dias_vacacion', fecha_calculo='$fecha_calculo' where id_vacacion=$id_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_vacacion_acumulada($id_vacacion, $cantidad_dias)
	{
		$registros_d = $this->bd->Consulta("select (sum(cantidad_dias)-sum(dias_utilizados)) as acumulados from detalle_vacacion where id_vacacion=$id_vacacion");
		$registro_d = $this->bd->getFila($registros_d);
		$vacacion_acumulada = $registro_d[acumulados];
		$registros = $this->bd->Consulta("update vacacion set vacacion_acumulada='$vacacion_acumulada' where id_vacacion=$id_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function actualizar_vacacion_acumulada($id_vacacion)
	{
		$registros_d = $this->bd->Consulta("select (sum(cantidad_dias) - sum(dias_utilizados)) as acumulados from detalle_vacacion where id_vacacion=$id_vacacion");
		$registro_d = $this->bd->getFila($registros_d);
		$vacacion_acumulada = $registro_d[acumulados];
		$registros = $this->bd->Consulta("update vacacion set vacacion_acumulada='$vacacion_acumulada' where id_vacacion=$id_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_vacacion)
	{
		$registros = $this->bd->Consulta("delete from vacacion where id_vacacion=$id_vacacion ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_vacacion($id_vacacion)
	{
		$registros = $this->bd->Consulta("select * from vacacion where id_vacacion=$id_vacacion");
		$registro = $this->bd->getFila($registros);

		$this->id_vacacion = $registro[id_vacacion];
		$this->fecha_ingreso = $registro[fecha_ingreso];
		$this->anios_empresa = $registro[anios_empresa];
		$this->meses_empresa = $registro[meses_empresa];
		$this->dias_empresa = $registro[dias_empresa];
		$this->dias_vacacion = $registro[dias_vacacion];
		$this->fecha_calculo = $registro[fecha_calculo];
		$this->id_trabajador = $registro[id_trabajador];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from vacacion $where");
			return $registros;
	}

	function modificar_vacacion_observacion($id_vacacion_find, $accumulated) {
		$buscar_vacacion = $this->bd->Consulta("SELECT id_vacacion FROM detalle_vacacion WHERE id_detalle_vacacion = $id_vacacion_find");
		$buscar = $this->bd->getFila($buscar_vacacion);
		$id_vacacion = $buscar[id_vacacion];
		$registros = $this->bd->Consulta("UPDATE vacacion SET vacacion_acumulada='$accumulated' WHERE id_vacacion = $id_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>