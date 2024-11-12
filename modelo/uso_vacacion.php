<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class uso_vacacion
{
	public $id_uso_vacacion;
	public $fecha_registro;
	public $gestion_inicio;
	public $gestion_fin;
	public $fecha_inicio;
	public $fecha_fin;
	public $cantidad_dias;
	public $id_papeleta_vacacion;
	private $bd;

	function uso_vacacion()
	{
		$this->bd = new conexion();
	}
	function registrar_uso_vacacion($fecha_registro, $gestion_inicio, $gestion_fin, $fecha_inicio, $fecha_fin, $cantidad_dias, $id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("insert into uso_vacacion values('', '$fecha_registro', '$gestion_inicio', '$gestion_fin', '$fecha_inicio', '$fecha_fin', '$cantidad_dias', '$cantidad_dias', '$id_papeleta_vacacion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_uso_vacacion($id_uso_vacacion, $fecha_registro, $gestion_inicio, $gestion_fin, $fecha_inicio, $fecha_fin, $cantidad_dias, $id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("update papeleta_vacacion set fecha_solicitud='$fecha_solicitud', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', dias_solicitados='$dias_solicitados', estado='$estado', autorizado_por='$autorizado_por', observacion='$observacion', id_detalle_vacacion='$id_detalle_vacacion' where id_papeleta_vacacion=$id_papeleta_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("delete from detalle_vacacion where id_papeleta_vacacion=$id_papeleta_vacacion ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_papeleta_vacacion($id_papeleta_vacacion)
	{
		$registros = $this->bd->Consulta("select * from papeleta_vacacion where id_papeleta_vacacion=$id_papeleta_vacacion");
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

	function dias_ejecutados($id, $dias_ejecutados) {
		$registros = $this->bd->Consulta("UPDATE uso_vacacion SET dias_ejecutados = '$dias_ejecutados' WHERE id_papeleta_vacacion = $id");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from papeleta_vacacion $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>