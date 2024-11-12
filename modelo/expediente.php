<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class expediente
{
	public $id_expediente;
	public $fecha_registro;
	public $nombre_archivo;
    public $nro_fojas;
    public $observacion;
	public $archivo;
	public $id_usuario_elapas;
	private $bd;

	function expediente()
	{
		$this->bd = new Conexion();
	}
	function registrar_expediente($fecha_registro,$nombre_archivo, $nro_fojas, $observacion, $archivo, $id_usuario_elapas)
	{
		$registros = $this->bd->Consulta("insert into expediente values('', '$fecha_registro', '$nombre_archivo','$nro_fojas', '$observacion', '$archivo', '$id_usuario_elapas')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_expediente($id_expediente, $nombre_archivo, $nro_fojas, $observacion)
	{
		$registros = $this->bd->Consulta("update expediente set nombre_archivo='$nombre_archivo', nro_fojas='$nro_fojas', observacion='$observacion' where id_expediente=$id_expediente");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_expediente($id_expediente)
	{
		$registros = $this->bd->Consulta("select * from expediente where id_expediente=$id_expediente");
		$registro = $this->bd->getFila($registros);

		$this->id_expediente = $registro[id_expediente];
		$this->fecha_registro = $registro[fecha_registro];
		$this->nombre_archivo = $registro[nombre_archivo];
		$this->nro_fojas = $registro[nro_fojas];
        $this->observacion = $registro[observacion];
		$this->archivo = $registro[archivo];
		$this->id_usuario_elapas = $registro[id_usuario_elapas];
    }
	function extraer_id($codigo_catastral){
		$registros = $this->bd->Consulta("select * from expediente where codigo_catastral=$codigo_catastral");
		$registro = $this->bd->getFila($registros);

		$this->id_expediente = $registro[id_expediente];
		$this->nombre_archivo = $registro[nombre_archivo];
		$this->nr_fojas = $registro[nr_fojas];
        $this->codigo_catastral = $registro[codigo_catastral];
		$this->observacion = $registro[observacion];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from expediente $where");
			return $registros;
	}    
    function bloquear($id_expediente)
	{
		$registros = $this->bd->Consulta("update expediente set estado=0 where id_expediente=$id_expediente");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_expediente)
	{
		$registros = $this->bd->Consulta("update expediente set estado=1 where id_expediente=$id_expediente");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_expediente)
	{
		$registros = $this->bd->Consulta("delete from expediente where id_expediente=$id_expediente");
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