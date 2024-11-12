<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class telefono 
{
	public $id_telefono;
	public $telf_interno;
	public $id_trabajador;
	public $id_cargo;



	private $bd;

	function telefono()
	{
		$this->bd = new Conexion();
	}
	function registrar_telefono($telf_interno, $id_trabajador, $id_cargo)
	{
		$registros = $this->bd->Consulta("insert into telefono values('', '$telf_interno', '$id_trabajador', '$id_cargo')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_telefono($id_telefono, $telf_interno, $id_trabajador, $id_cargo)
	{

        $registros = $this->bd->Consulta("update telefono set  id_trabajador='$_idtrabajador', telf_interno='$telf_interno'  where id_telefono=$id_telefono");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_telefono($id_telefono)
	{
		$registros = $this->bd->Consulta("select * from telefono where id_telefono=$id_telefono");
		$registro = $this->bd->getFila($registros);

		$this->id_telefono = $registro[id_telefono];
		$this->id_trabajador = $registro[id_trabajador];
		$this->telf_interno = $registro[telf_interno];
		$this->estado = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from telefono $where");
			return $registros;
	}    
    function bloquear($id_telefono)
	{
		$registros = $this->bd->Consulta("update id_ set estado=0 where id_telefono=$id_telefono");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_telefono)
	{
		$registros = $this->bd->Consulta("update telefono set estado=1 where id_telefono=$id_telefono");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_telefono)
	{
		$registros = $this->bd->Consulta("delete from telefono where id_telefono=$id_telefono");
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