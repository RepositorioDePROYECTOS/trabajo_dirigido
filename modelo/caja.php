<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class caja 
{
	public $id_caja;
	public $nro_caja;
	public $estado;
	public $id_fila;

	private $bd;

	function caja()
	{
		$this->bd = new Conexion();
	}
	function registrar_caja($nro_caja, $estado, $id_fila)
	{
		$registros = $this->bd->Consulta("insert into caja values('', '$nro_caja', '$estado', '$id_fila')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_caja($id_caja, $nro_caja, $id_fila)
	{
	   if(empty($codigo))
			//REVISAR
            $registros = $this->bd->Consulta("update caja set  id_estante='$id_fila' where id_caja=$id_caja");
       else        
            $registros = $this->bd->Consulta("update caja set nro_caja='$nro_caja', id_fila='$id_fila' where id_caja=$id_caja");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_caja($id_caja)
	{
		$registros = $this->bd->Consulta("select * from caja where id_caja=$id_caja");
		$registro = $this->bd->getFila($registros);

		$this->id_caja = $registro[id_caja];
		$this->nro_caja = $registro[nro_caja];
		$this->estado = $registro[estado];
		$this->id_fila = $registro[id_fila];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from caja $where");
			return $registros;
	}    
    function bloquear($id_caja)
	{
		$registros = $this->bd->Consulta("update caja set estado=0 where id_caja=$id_caja");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_caja)
	{
		$registros = $this->bd->Consulta("update caja set estado=1 where id_caja=$id_caja");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_caja)
	{
		$registros = $this->bd->Consulta("delete from caja where id_caja=$id_caja");
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