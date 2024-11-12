<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class proveedor
{
	public $id_proveedor;
	public $nombre;
	public $nit;
	public $contacto;
	public $doc_contacto;
	public $direccion;
	public $telefono;
	public $celular;
	public $correo;
	public $observacion;
	public $codigo_usuario;
	public $estado;
	private $bd;

	function proveedor()
	{
		$this->bd = new Conexion();
	}
	function registrar_proveedor($nombre, $nit, $contacto, $doc_contacto, $direccion, $telefono, $celular, $correo, $observacion, $codigo_usuario, $estado)
	{
		$registros = $this->bd->Consulta("INSERT INTO proveedores VALUES ('','$nombre', '$nit', '$contacto', '$doc_contacto', '$direccion', '$telefono', '$celular', '$correo', '$observacion', '$codigo_usuario', '$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
    function editar_proveedor($id_proveedor, $nombre, $nit, $direccion, $telefono, $celular, $observacion, $codigo_usuario)
	{
		$registros = $this->bd->Consulta("UPDATE proveedores SET nombre='$nombre', nit='$nit', direccion='$direccion', telefono='$telefono', celular='$celular', observacion='$observacion', codigo_usuario='$codigo_usuario' WHERE id_proveedor=$id_proveedor");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function get_proveedor($id_proveedor)
	{
		$registros = $this->bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$id_proveedor");
		$registro = $this->bd->getFila($registros);

		$this->id_proveedor = $registro[id_proveedor];
		$this->nombre       = $registro[nombre];
        $this->nit          = $registro[nit];
        $this->contacto     = $registro[contacto];
        $this->doc_contacto = $registro[doc_contacto];
        $this->direccion    = $registro[direccion];
        $this->telefono     = $registro[telefono];
        $this->celular      = $registro[celular];
        $this->correo       = $registro[correo];
        $this->observacion  = $registro[observacion];
    }
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("SELECT * FROM proveedores $where");
			return $registros;
	}    
    function eliminar($id_proveedor)
	{
		$registros = $this->bd->Consulta("DELETE FROM proveedores where id_proveedor=$id_proveedor");
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