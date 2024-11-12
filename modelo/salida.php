<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class salida
{
	public $id_salida;
    public $hora_retorno;
    public $hora_exac_llegada;
    public $hora_salida;
	public $hora_e_salida;
    public $direccion_salida;
	public $horas_justificacion_real;
    public $motivo;
    public $observaciones;
    public $fecha;
    public $vehiculo;
    public $usuario;
    public $tipo_salida;//2
	private $bd;

	function salida()
	{
		$this->bd = new Conexion();
	}
	function registrar_salida($hora_retorno, $hora_exac_llegada, $hora_salida,$hora_e_salida, $horas_justificacion_real, $direccion_salida, $motivo, $observaciones, $fecha, $vehiculo, $usuario, $tipo_salida, $id_chofer, $estado)
	{
		$registros = $this->bd->Consulta("insert into salida values('','$hora_retorno', '$hora_exac_llegada', '$hora_salida','$hora_e_salida', '$horas_justificacion_real','00:00', '$direccion_salida', '$motivo', '$observaciones', '$fecha', '$vehiculo', '$usuario', '$tipo_salida', '$id_chofer','$estado')");
		//$registros = $this->bd->Consulta("insert into salida values('','20:57', '', '19:57', '1:00', 'PARTICULAR', 'PARTICULAR', '-', '2021-06-10', '0', '8', '1', '0','0')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_salida($id_salida, $hora_exac_llegada)
	{
	   $registros = $this->bd->Consulta("update salida set hora_exac_llegada='$hora_exac_llegada' where id_salida=$id_salida");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_salida($id_salida)
	{
		$registros = $this->bd->Consulta("select * from salida where id_salida=$id_salida");
		$registro = $this->bd->getFila($registros);

		$this->id_salida = $registro[id_salida];
		$this->nombre = $registro[nombre];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from salida $where");
			return $registros;
	}
    function bloquear($id_salida)
	{
		$registros = $this->bd->Consulta("update salida set descripcion=0 where id_salida=$id_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_salida)
	{
		$registros = $this->bd->Consulta("update tipo_estante set descripcion=1 where id_salida=$id_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_salida)
	{
		$registros = $this->bd->Consulta("delete from salida where id_salida=$id_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function modificarhora($id_salida, $hora_exac_llegada,$tiempo_usado)
	{
		$registros = $this->bd->Consulta("update salida set tiempo_usado='$tiempo_usado',hora_exac_llegada = '$hora_exac_llegada', estado=2 where id_salida=$id_salida");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_estado_s($id_salida, $estado, $hora_e_salida)
	{
		$registros = $this->bd->Consulta("update salida set hora_e_salida='$hora_e_salida', estado = '$estado' where id_salida=$id_salida");
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