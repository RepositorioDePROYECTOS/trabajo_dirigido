<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class ingreso_funcionario
{
	public $id_ingreso_funcionario;
    public $fecha_registro;
    public $fecha_ingreso;
    public $hora_inicio;
    public $hora_fin;
	public $motivo_ingreso;
    public $observacion;
    public $autorizado_por;
    public $estado_ingreso;
    public $id_usuario;
	private $bd;

	function ingreso_funcionario()
	{
		$this->bd = new Conexion();
	}
	function registrar_ingreso_funcionario($fecha_registro, $fecha_ingreso, $hora_inicio, $hora_fin, $motivo_ingreso, $observacion, $autorizado_por, $estado_ingreso, $id_usuario)
	{
		$registros = $this->bd->Consulta("insert into ingreso_funcionario values('','$fecha_registro', '$fecha_ingreso', '$hora_inicio', '$hora_fin', '$motivo_ingreso', '$observacion', '$autorizado_por', '$estado_ingreso', '$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_ingreso_funcionario($id_ingreso_funcionario, $fecha_ingreso, $hora_inicio, $hora_fin, $motivo_ingreso, $observacion, $autorizado_por, $estado_ingreso, $id_usuario)
	{
	   $registros = $this->bd->Consulta("update ingreso_funcionario set fecha_ingreso='$fecha_ingreso', hora_inicio='$hora_inicio', hora_fin='$hora_fin', motivo_ingreso='motivo_ingreso', observacion='$observacion', autorizado_por='$autorizado_por', estado_ingreso='$estado_ingreso' where id_ingreso_funcionario=$id_ingreso_funcionario");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_ingreso_funcionario($id_ingreso_funcionario)
	{
		$registros = $this->bd->Consulta("select * from ingreso_funcionario where id_ingreso_funcionario=$id_ingreso_funcionario");
		$registro = $this->bd->getFila($registros);

		$this->id_ingreso_funcionario = $registro[id_ingreso_funcionario];
		$this->fecha_registro = $registro[fecha_registro];
		$this->fecha_ingreso = $registro[fecha_ingreso];
		$this->hora_inicio = $registro[hora_inicio];
		$this->hora_fin = $registro[hora_fin];
		$this->motivo_ingreso = $registro[motivo_ingreso];
		$this->observacion = $registro[observacion];
		$this->autorizado_por = $registro[autorizado_por];
		$this->estado_ingreso = $registro[estado_ingreso];
		$this->id_usuario = $registro[id_usuario];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from ingreso_funcionario $where");
			return $registros;
	}
    function autorizar($id_ingreso_funcionario)
	{
		$registros = $this->bd->Consulta("update ingreso_funcionario set estado_ingreso='AUTORIZADO' where id_ingreso_funcionario=$id_ingreso_funcionario");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function rechazar($id_ingreso_funcionario)
	{
		$registros = $this->bd->Consulta("update ingreso_funcionario set estado_ingreso='RECHAZADO' where id_ingreso_funcionario=$id_ingreso_funcionario");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_ingreso_funcionario)
	{
		$registros = $this->bd->Consulta("delete from ingreso_funcionario where id_ingreso_funcionario=$id_ingreso_funcionario");
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