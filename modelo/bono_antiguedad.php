<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class bono_antiguedad
{
	public $id_bono_antiguedad;
	public $anios_arrastre;
	public $meses_arrastre;
	public $dias_arrastre;
	public $fecha_ingreso;
	public $fecha_calculo;
	public $anios;
	public $meses;
	public $dias;
	public $gestion;
	public $mes;
	public $porcentaje;
	public $monto;
	public $id_asignacion_cargo;
	private $bd;

	function bono_antiguedad()
	{
		$this->bd = new conexion();
	}
	function registrar_bono_antiguedad($anios_arrastre, $meses_arrastre, $dias_arrastre, $fecha_ingreso, $fecha_calculo, $anios, $meses, $dias, $gestion, $mes, $porcentaje, $monto, $id_asignacion_cargo)
	{
		$registros_b = $this->bd->Consulta("select * from bono_antiguedad where mes = $mes and gestion = $gestion and id_asignacion_cargo = $id_asignacion_cargo");
		if($this->bd->numFila($registros_b) == 0)
		{
			$registros = $this->bd->Consulta("insert into bono_antiguedad values('', '$anios_arrastre', '$meses_arrastre', '$dias_arrastre', '$fecha_ingreso', '$fecha_calculo', '$anios', '$meses', '$dias', '$gestion', '$mes', '$porcentaje', '$monto', '$id_asignacion_cargo')");
			if($this->bd->numFila_afectada()>0)
				return true;
			else
				return false;
		}
	}
	function modificar_bono_antiguedad($id_bono_antiguedad, $monto)
	{
		$registros = $this->bd->Consulta("update bono_antiguedad set monto=$monto where id_bono_antiguedad=$id_bono_antiguedad");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("delete from bono_antiguedad where id_bono_antiguedad=$id_bono_antiguedad ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from bono_antiguedad where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_bono_antiguedad($id_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("select * from bono_antiguedad where id_bono_antiguedad=$id_bono_antiguedad");
		$registro = $this->bd->getFila($registros);

		$this->id_bono_antiguedad = $registro[id_bono_antiguedad];
		$this->anios = $registro[anios];
		$this->porcentaje = $registro[porcentaje];
		$this->monto = $registro[monto];
		$this->estado_bono = $registro[estado_bono];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from bono_antiguedad $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>