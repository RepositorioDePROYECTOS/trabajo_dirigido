<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class tipo_estante
{
	public $id_tipo_estante;
	public $categoria;
	public $descripcion;
	private $bd;

	function tipo_estante()
	{
		$this->bd = new Conexion();
	}
	function registrar_tipo_estante($categoria, $descripcion)
	{
		$registros = $this->bd->Consulta("insert into tipo_estante values('', '$categoria', '$descripcion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_tipo_estante($id_tipo_estante, $categoria, $descripcion)
	{
	   if(empty($categoria))
            $registros = $this->bd->Consulta("update tipo_estante set categoria='$categoria', descripcion='$descripcion' where id_tipo_estante=$id_tipo_estante");
       else        
            $registros = $this->bd->Consulta("update tipo_estante set categoria='$categoria', descripcion='$descripcion' where id_tipo_estante=$id_tipo_estante");
        
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_usuario($id_tipo_estante)
	{
		$registros = $this->bd->Consulta("select * from tipo_estante where id_tipo_estante=$id_tipo_estante");
		$registro = $this->bd->getFila($registros);

		$this->id_tipo_estante = $registro[id_tipo_estante];
		$this->categoria = $registro[categoria];
		$this->descripcion = $registro[descripcion];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from tipo_estante $where");
			return $registros;
	}    
    function bloquear($id_tipo_estante)
	{
		$registros = $this->bd->Consulta("update tipo_estante set descripcion=0 where id_tipo_estante=$id_tipo_estante");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function habilitar($id_tipo_estante)
	{
		$registros = $this->bd->Consulta("update tipo_estante set descripcion=1 where id_tipo_estante=$id_tipo_estante");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_tipo_estante)
	{
		$registros = $this->bd->Consulta("delete from tipo_estante where id_tipo_estante=$id_tipo_estante");
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