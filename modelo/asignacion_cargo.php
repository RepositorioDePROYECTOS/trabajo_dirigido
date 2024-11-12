<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class asignacion_cargo
{
	public $id_asignacion_cargo;
	public $fecha_ingreso;
	public $fecha_salida;
	public $item;
	public $salario;
	public $cargo;
	public $estado_asignacion;
	public $aportante_afp;
	public $sindicato;
	public $socio_fe;
	public $id_cargo;
	public $id_trabajador;
	private $bd;

	function asignacion_cargo()
	{
		$this->bd = new conexion();
	}
	function registrar_asignacion_cargo($fecha_ingreso, $fecha_salida, $item, $salario, $cargo, $estado_asignacion, $aportante_afp, $sindicato, $socio_fe, $id_cargo, $id_trabajador)
	{
		$registros = $this->bd->Consulta("insert into asignacion_cargo values('','$fecha_ingreso', '$fecha_salida', '$item', '$salario', '$cargo', '$estado_asignacion', '$aportante_afp', '$sindicato', '$socio_fe', '$id_cargo', '$id_trabajador')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_asignacion_cargo($id_asignacion_cargo, $fecha_ingreso, $fecha_salida, $item, $salario, $cargo, $estado_asignacion, $aportante_afp, $sindicato, $socio_fe, $id_cargo, $id_trabajador)
	{
		$registros = $this->bd->Consulta("update asignacion_cargo set fecha_ingreso='$fecha_ingreso', fecha_salida='$fecha_salida', item='$item', salario='$salario', cargo='$cargo', estado_asignacion='$estado_asignacion', aportante_afp='$aportante_afp', sindicato='$sindicato', socio_fe='$socio_fe', id_cargo='$id_cargo', id_trabajador='$id_trabajador' where id_asignacion_cargo=$id_asignacion_cargo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function dar_baja_asignacion_cargo($id_asignacion_cargo, $fecha_salida, $estado_asignacion)
	{
		$registros = $this->bd->Consulta("update asignacion_cargo set  fecha_salida='$fecha_salida', estado_asignacion='$estado_asignacion' where id_asignacion_cargo=$id_asignacion_cargo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("delete from asignacion_cargo where id_asignacion_cargo=$id_asignacion_cargo ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_asignacion_cargo($id_asignacion_cargo)
	{
		$registros = $this->bd->Consulta("select * from asignacion_cargo where id_asignacion_cargo=$id_asignacion_cargo");
		$registro = $this->bd->getFila($registros);

		$this->id_asignacion_cargo = $registro[id_asignacion_cargo];
		$this->fecha_ingreso = $registro[fecha_ingreso];
		$this->fecha_salida = $registro[fecha_salida];
		$this->item = $registro[item];
		$this->salario = $registro[salario];
		$this->cargo = $registro[cargo];
		$this->estado_asignacion = $registro[estado_asignacion];
		$this->aportante_afp = $registro[aportante_afp];
		$this->sindicato = $registro[sindicato];
		$this->socio_fe = $registro[socio_fe];
		$this->id_cargo = $registro[id_cargo];
		$this->id_trabajador = $registro[id_trabajador];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from asignacion_cargo $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>