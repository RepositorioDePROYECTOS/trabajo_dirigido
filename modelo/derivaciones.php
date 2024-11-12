<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class derivaciones
{
	public $id_derivacion;
	public $id_solicitud;
	public $nro_solicitud;
	public $id_trabajador;
	public $tipo_solicitud;
	public $fecha_derivado;
	public $fecha_respuesta;
	public $estado_derivacion;
	private $bd;

	function derivaciones()
	{
		$this->bd = new conexion();
	}
	function registrar_derivacion($id_solicitud, $nro_solicitud, $id_trabajador, $tipo_solicitud, $fecha_derivado, $fecha_respuesta, $estado_derivacion, $tipo_trabajador)
	{
		$registros = $this->bd->Consulta("INSERT INTO derivaciones (id_solicitud, nro_solicitud,id_trabajador,tipo_solicitud,tipo_trabajador,fecha_derivado,fecha_respuesta,estado_derivacion) values ( '$id_solicitud', '$nro_solicitud','$id_trabajador', '$tipo_solicitud', '$tipo_trabajador', '$fecha_derivado', '$fecha_respuesta', '$estado_derivacion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	// function modificar_conf_vacacion($id_conf_vacacion, $anio_inicio, $anio_fin, $dias_vacacion, $estado_vaca)
	// {
	// 	$registros = $this->bd->Consulta("update conf_vacacion set anio_inicio='$anio_inicio', anio_fin='$anio_fin', dias_vacacion='$dias_vacacion', estado_vaca='$estado_vaca' where id_conf_vacacion=$id_conf_vacacion");
	// 	if($this->bd->numFila_afectada($registros)>0)
	// 		return true;
	// 	else
	// 		return false;
	// }
	function devolver($id_derivacion)
	{
		$registros = $this->bd->Consulta("UPDATE derivaciones set estado_derivacion='solicitar' where id_derivacion=$id_derivacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function cambiar($id_derivacion)
	{
		$registros = $this->bd->Consulta("UPDATE derivaciones set estado_derivacion='solicitado' where id_derivacion=$id_derivacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	// function get_conf_vacacion($id_conf_vacacion)
	// {
	// 	$registros = $this->bd->Consulta("select * from conf_vacacion where id_conf_vacacion=$id_conf_vacacion");
	// 	$registro = $this->bd->getFila($registros);

	// 	$this->id_conf_vacacion = $registro[id_conf_vacacion];
	// 	$this->anio_inicio = $registro[anio_inicio];
	// 	$this->anio_fin = $registro[anio_fin];
	// 	$this->dias_vacacion = $registro[dias_vacacion];
	// 	$this->estado_vaca = $registro[estado_vaca];
	// }
	// function get_all($criterio)
	// {
	// 	if(empty($criterio)) $where = ""; else $where = " $criterio";
	// 	$registros = $this->bd->Lista("select * from conf_vacacion $where");
	// 		return $registros;
	// }
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>