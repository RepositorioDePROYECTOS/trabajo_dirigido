<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class papeleta_vacacion
{
	public $id_papeleta_vacacion;
	public $fecha_solicitud;
	public $fecha_inicio;
	public $fecha_fin;
	public $dias_solicitados;
	public $estado;
	public $autorizado_por;
	public $observacion;
	public $id_detalle_vacacion;
	private $bd;

	function papeleta_vacacion()
	{
		$this->bd = new conexion();
	}
	function registrar_papeleta_vacacion($fecha_solicitud, $fecha_inicio, $fecha_fin, $dias_solicitados, $estado, $autorizado_por, $observacion, $id_detalle_vacacion, $restante)
	{
		$registros = $this->bd->Consulta("INSERT into papeleta_vacacion (`id_papeleta_vacacion`, `fecha_solicitud`, `fecha_inicio`, `fecha_fin`, `dias_solicitados`, `saldo_dias`, `estado`, `autorizado_por`, `observacion`, `id_detalle_vacacion`) values('', '$fecha_solicitud', '$fecha_inicio', '$fecha_fin', '$dias_solicitados', '$restante', '$estado', '$autorizado_por', '$observacion', '$id_detalle_vacacion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_papeleta_vacacion($id_papeleta_vacacion, $fecha_solicitud, $dias_solicitados, $estado, $autorizado_por, $observacion, $id_detalle_vacacion)
	{
		$registros = $this->bd->Consulta("UPDATE papeleta_vacacion 
			set fecha_solicitud='$fecha_solicitud', 
			fecha_inicio='$fecha_inicio', 
			fecha_fin='$fecha_fin', 
			dias_solicitados='$dias_solicitados', 
			estado='$estado', 
			autorizado_por='$autorizado_por', 
			observacion='$observacion', 
			id_detalle_vacacion='$id_detalle_vacacion' 
			WHERE id_papeleta_vacacion=$id_papeleta_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function aprobar($id_papeleta_vacacion)
	{
		$estado = 'APROBADO';
		$registros = $this->bd->Consulta("UPDATE papeleta_vacacion SET estado='$estado' WHERE id_papeleta_vacacion=$id_papeleta_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar($id_papeleta_vacacion)
	{
		$estado = 'RECHAZADO';
		$registros = $this->bd->Consulta("UPDATE papeleta_vacacion SET estado='$estado' WHERE id_papeleta_vacacion=$id_papeleta_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("delete from papeleta_vacacion WHERE id_papeleta_vacacion=$id_papeleta_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_papeleta_vacacion($id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("select * from papeleta_vacacion WHERE id_papeleta_vacacion=$id_papeleta_vacacion");
		$registro = $this->bd->getFila($registros);

		$this->id_papeleta_vacacion = $registro[id_papeleta_vacacion];
		$this->fecha_solicitud = $registro[fecha_solicitud];
		$this->fecha_inicio = $registro[fecha_inicio];
		$this->fecha_fin = $registro[fecha_fin];
		$this->dias_solicitados = $registro[dias_solicitados];
		$this->estado = $registro[estado];
		$this->autorizado_por = $registro[autorizado_por];
		$this->observacion = $registro[observacion];
		$this->id_detalle_vacacion = $registro[id_detalle_vacacion];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $WHERE = ""; else $WHERE = " $criterio";
		$registros = $this->bd->Lista("select * from papeleta_vacacion $WHERE");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>