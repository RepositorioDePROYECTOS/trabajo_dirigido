<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class trabajador
{
	public $id_trabajador;
	public $ci;
	public $exp;
	public $nua;
	public $nombres;
	public $apellido_paterno;
	public $apellido_materno;
	public $direccion;
	public $sexo;
	public $nacionalidad;
	public $fecha_nacimiento;
	public $antiguedad_anios;
	public $antiguedad_meses;
	public $antiguedad_dias;
	public $estado_trabajador;
	private $bd;

	function trabajador()
	{
		$this->bd = new conexion();
	}
	function registrar_trabajador($ci, $exp, $nua, $nombres, $apellido_paterno, $apellido_materno, $direccion, $sexo, $nacionalidad, $fecha_nacimiento, $antiguedad_anios, $antiguedad_meses, $antiguedad_dias, $estado_trabajador)
	{
		$registros = $this->bd->Consulta("insert into trabajador values('', '$ci', '$exp', '$nua', '$nombres', '$apellido_paterno', '$apellido_materno', '$direccion', '$sexo', '$nacionalidad', '$fecha_nacimiento', '$antiguedad_anios', '$antiguedad_meses', '$antiguedad_dias' , '$estado_trabajador')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_trabajador($id_trabajador, $ci, $exp, $nua, $nombres, $apellido_paterno, $apellido_materno, $direccion, $sexo, $nacionalidad, $fecha_nacimiento, $antiguedad_anios, $antiguedad_meses, $antiguedad_dias, $estado_trabajador)
	{
		$registros = $this->bd->Consulta("update trabajador set ci='$ci', exp='$exp', nua='$nua', nombres='$nombres', apellido_paterno='$apellido_paterno',
			apellido_materno='$apellido_materno',  direccion='$direccion', sexo='$sexo', nacionalidad='$nacionalidad', fecha_nacimiento='$fecha_nacimiento', antiguedad_anios='$antiguedad_anios', antiguedad_meses='$antiguedad_meses', antiguedad_dias='$antiguedad_dias', estado_trabajador='$estado_trabajador' where id_trabajador=$id_trabajador");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function retirar_trabajador($id_trabajador)
	{
		$registros = $this->bd->Consulta("update trabajador set estado_trabajador='RETIRADO' where id_trabajador=$id_trabajador");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_trabajador)
	{
		$registros = $this->bd->Consulta("delete from trabajador where id_trabajador=$id_trabajador ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_trabajador($id_trabajador)
	{
		$registros = $this->bd->Consulta("select * from trabajador where id_trabajador=$id_trabajador");
		$registro = $this->bd->getFila($registros);

		$this->id_trabajador = $registro[id_trabajador];
		$this->ci = $registro[ci];
		$this->exp = $registro[exp];
		$this->nua = $registro[nua];
		$this->nombres = $registro[nombres];
		$this->apellido_paterno = $registro[apellido_paterno];
		$this->apellido_materno = $registro[apellido_materno];
		$this->direccion = $registro[direccion];
		$this->sexo = $registro[sexo];
		$this->nacionalidad = $registro[nacionalidad];
		$this->fecha_nacimiento = $registro[fecha_nacimiento];
		$this->antiguedad_anios = $registro[antiguedad_anios];
		$this->antiguedad_meses = $registro[antiguedad_meses];
		$this->antiguedad_dias = $registro[antiguedad_dias];
		$this->estado_trabajador = $registro[estado_trabajador];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from trabajador $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>