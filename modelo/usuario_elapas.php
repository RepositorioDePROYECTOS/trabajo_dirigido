<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class usuario_elapas
{
	public $id_usuario_elapas;
	public $codigo_catastral_actual;
	public $codigo_catastral_antiguo;
	public $numero_cuenta;
	public $nombre_usuario;
	public $documento;
	public $direccion;
	public $categoria;
	public $paralelo;
	public $codigo_catastral_origen;
	public $numero_cuenta_origen;
	public $estado;
	private $bd;

	function usuario_elapas()
	{
		$this->bd = new Conexion();
	}
	function registrar_usuario_elapas($codigo_catastral_actual, $codigo_catastral_antiguo, $numero_cuenta, $nombre_usuario, $documento, $direccion, $categoria, $paralelo, $codigo_catastral_origen, $numero_cuenta_origen, $estado)
	{
		$registros = $this->bd->Consulta("insert into usuario_elapas values('', '$codigo_catastral_actual', '$codigo_catastral_antiguo', '$numero_cuenta', '$nombre_usuario', '$documento', '$direccion', '$categoria', '$paralelo', '$codigo_catastral_origen', '$numero_cuenta_origen', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_usuario_elapas($id_usuario_elapas,$codigo_catastral_actual, $codigo_catastral_antiguo, $numero_cuenta, $nombre_usuario, $documento, $direccion, $categoria, $paralelo, $codigo_catastral_origen, $numero_cuenta_origen, $estado)
	{
	   $registros = $this->bd->Consulta("update usuario_elapas set codigo_catastral_actual='$codigo_catastral_actual', codigo_catastral_antiguo= '$codigo_catastral_antiguo', numero_cuenta='$numero_cuenta', nombre_usuario='$nombre_usuario', documento='$documento', direccion='$direccion', categoria= '$categoria', paralelo='$paralelo', codigo_catastral_origen= '$codigo_catastral_origen', numero_cuenta_origen= '$numero_cuenta_origen',estado= '$estado' where id_usuario_elapas=$id_usuario_elapas");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_usuario_elapas($id_usuario_elapas)
	{
		$registros = $this->bd->Consulta("select * from usuario_elapas where id_usuario_elapas=$id_usuario_elapas");
		
		$registro = $this->bd->getFila($registros);

		$this->id_usuario_elapas = $registro[id_usuario_elapas];
		$this->codigo_catastral_actual = $registro[codigo_catasstral_actual];
		$this->codigo_catastral_antiguo = $registro[codigo_catasstral_antiguo];
		$this->numero_cuenta = $registro[numero_cuenta];
		$this->nombre_usuario = $registro[nombre_usuario];
        $this->documento = $registro[documento];
		$this->direccion = $registro[direccion];
		$this->categoria = $registro[categoria];
		$this->paralelo = $registro[paralelo];
		$this->codigo_catastral_origen = $registro[codigo_catastral_origen];
		$this->numero_cuenta_origen = $registro[numero_cuenta_origen];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = "$criterio";
		$registros = $this->bd->Lista("select * from usuario_elapas $where");
			return $registros;
	}    
    function bloquear($id_usuario_elapas)
	{
		$registros = $this->bd->Consulta("update usuario_elapas set estado=0 where id_user_ex=$id_usuario_elapas");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_usuario_elapas)
	{
		$registros = $this->bd->Consulta("update usuario_elapas set estado=1 where id_usuario_elapas=$id_usuario_elapas");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_usuario_elapas)
	{
		$registros = $this->bd->Consulta("delete from usuario_elapas where id_usuario_elapas=$id_usuario_elapas");
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