<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_bono_antiguedad
{
	public $id_conf_bono_antiguedad;
	public $anio_i;
	public $anio_f;
	public $porcentaje;
	public $estado_bono;
	private $bd;

	function conf_bono_antiguedad()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_bono_antiguedad($anio_i, $anio_f, $porcentaje, $estado_bono)
	{
		$registros = $this->bd->Consulta("insert into conf_bono_antiguedad values('','$anio_i', '$anio_f', '$porcentaje','$estado_bono')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_bono_antiguedad($id_conf_bono_antiguedad, $anio_i, $anio_f, $porcentaje, $estado_bono)
	{
		$registros = $this->bd->Consulta("update conf_bono_antiguedad set anio_i='$anio_i', anio_f='$anio_f', porcentaje='$porcentaje', estado_bono='$estado_bono' where id_conf_bono_antiguedad=$id_conf_bono_antiguedad");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("delete from conf_bono_antiguedad where id_conf_bono_antiguedad=$id_conf_bono_antiguedad");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_bono_antiguedad($id_conf_bono_antiguedad)
	{
		$registros = $this->bd->Consulta("select * from conf_bono_antiguedad where id_conf_bono_antiguedad=$id_conf_bono_antiguedad");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_bono_antiguedad = $registro[id_conf_bono_antiguedad];
		$this->anio_i = $registro[anio_i];
		$this->anio_f = $registro[anio_f];
		$this->porcentaje = $registro[porcentaje];
		$this->estado_bono = $registro[estado_bono];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from conf_aportes $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>