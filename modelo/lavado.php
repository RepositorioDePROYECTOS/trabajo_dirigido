<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class lavado
{
	public $id_lavado;
	public $fecha_solicitud;
	public $marca_vehiculo;
	public $tipo_vehiculo;
	public $numero_placa;
	public $jefatura;
	public $gerencia;
	public $estado_lavado;
	public $id_usuario;
	private $bd;

	function lavado()
	{
		$this->bd = new Conexion();
	}
	function registrar_lavado($fecha_solicitud, $marca_vehiculo, $tipo_vehiculo, $numero_placa, $jefatura, $gerencia, $estado_lavado, $id_usuario)
	{
		$registros = $this->bd->Consulta("insert into lavado values('', '$fecha_solicitud', '$marca_vehiculo', '$tipo_vehiculo', '$numero_placa', '$jefatura', '$gerencia', '$estado_lavado', '$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_lavado($id_lavado, $marca_vehiculo, $tipo_vehiculo, $numero_placa, $jefatura, $gerencia)
	{
	   $registros = $this->bd->Consulta("update lavado set marca_vehiculo='$marca_vehiculo', tipo_vehiculo='$tipo_vehiculo', numero_placa='$numero_placa',
	   jefatura='$jefatura',
	   gerencia='$gerencia'  
	   where id_lavado=$id_lavado");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_lavado($id_lavado)
	{
		$registros = $this->bd->Consulta("select * from lavado where id_lavado=$id_lavado");
		$registro = $this->bd->getFila($registros);
		$this->id_lavado = $registro[id_lavado];
		$this->fecha_solicitud = $registro[fecha_solicitud];
		$this->marca_vehiculo = $registro[marca_vehiculo];
		$this->tipo_vehiculo = $registro[tipo_vehiculo];
		$this->numero_placa = $registro[numero_placa];
		$this->jefatura = $registro[jefatura];
		$this->gerencia = $registro[gerencia];
		$this->estado_lavado = $registro[estado_lavado];
		$this->id_usuario = $registro[id_usuario];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from lavado $where");
			return $registros;
	}    
    function bloquear($id_lavado)
	{
		$registros = $this->bd->Consulta("update vehiculo set estado_lavado=0 where id_lavado=$id_lavado");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_lavado)
	{
		$registros = $this->bd->Consulta("update vehiculo set estado_lavado=1 where id_lavado=$id_lavado");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_lavado)
	{
		$registros = $this->bd->Consulta("delete from lavado where id_lavado=$id_lavado");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}    
	function __destroy()
	{
		$lavado = $this->bd->Cerrar();
	}
}
 
?>