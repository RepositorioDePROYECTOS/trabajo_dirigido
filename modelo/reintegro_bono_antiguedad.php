<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class reintegro_bono_antiguedad
{
	public $id_reintegro_bono_antiguedad;
	public $gestion_reintegro;
	public $mes_reintegro;
	public $porcentaje_reintegro;
	public $monto_reintegro;
	public $id_bono_antiguedad;
	private $bd;

	function reintegro_bono_antiguedad()
	{
		$this->bd = new conexion();
	}
	function registrar_reintegro_bono_antiguedad($gestion_reintegro, $mes_reintegro, $porcentaje_reintegro, $monto_reintegro, $id_bono_antiguedad)
	{
		$registros_b = $this->bd->Consulta("select * from reintegro_bono_antiguedad where mes_reintegro = $mes_reintegro and gestion_reintegro = $gestion_reintegro and id_bono_antiguedad = $id_bono_antiguedad");
		if($this->bd->numFila($registros_b) == 0)
		{
			$registros = $this->bd->Consulta("insert into reintegro_bono_antiguedad values('', '$gestion_reintegro', '$mes_reintegro', '$porcentaje_reintegro', '$monto_reintegro', '$id_bono_antiguedad')");
			if($this->bd->numFila_afectada()>0)
				return true;
			else
				return false;
		}
	}
	function modificar_reintegro_bono_antiguedad($id_reintegro_bono_antiguedad, $monto_reintegro)
	{
		$registros = $this->bd->Consulta("update reintegro_bono_antiguedad set monto_reintegro=$monto_reintegro where id_reintegro_bono_antiguedad=$id_reintegro_bono_antiguedad");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_reintegro_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("delete from reintegro_bono_antiguedad where id_reintegro_bono_antiguedad=$id_reintegro_bono_antiguedad ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($gestion_reintegro, $mes_reintegro)
	{
		$registros = $this->bd->Consulta("delete from reintegro_bono_antiguedad where gestion_reintegro=$gestion_reintegro and mes_reintegro=$mes_reintegro");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_reintegro_bono_antiguedad($id_reintegro_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("select * from reintegro_bono_antiguedad where id_reintegro_bono_antiguedad=$id_reintegro_bono_antiguedad");
		$registro = $this->bd->getFila($registros);

		$this->id_reintegro_bono_antiguedad = $registro[id_reintegro_bono_antiguedad];
		$this->gestion_reintegro = $registro[gestion_reintegro];
		$this->mes_reintegro = $registro[mes_reintegro];
		$this->porcentaje_reintegro = $registro[porcentaje_reintegro];
		$this->monto_reintegro = $registro[monto_reintegro];
		$this->id_bono_antiguedad = $registro[id_bono_antiguedad];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from reintegro_bono_antiguedad $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>