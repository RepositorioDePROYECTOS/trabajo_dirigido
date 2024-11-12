<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class requisitos
{
	public $id_requisitos;
    public $id_derivaciones;
    public $id_solicitud;
    public $id_trabajador;
    public $fecha_elaboracion;
    public $id_proveedor;
    public $id_detalle;
    public $modalidad_contratacion;
    public $plazo_entrega;
    public $forma_adjudicacion;
    public $multas_retraso;
    public $forma_pago;
    public $lugar_entrega;
    public $created_at;
	public $estado;
	private $bd;

	function requisitos()
	{
		$this->bd = new Conexion();
	}
	function registrar_requisitos($id_derivaciones,$id_solicitud,$id_trabajador,$fecha_elaboracion,$id_proveedor,$id_detalle,$created_at,$estado) // $modalidad_contratacion,$plazo_entrega,$forma_adjudicacion,$multas_retraso,$forma_pago,$lugar_entrega,
	{
		$registros = $this->bd->Consulta("INSERT into requisitos (id_derivaciones,id_solicitud,id_trabajador,fecha_elaboracion,id_proveedor,id_detalle,created_at,estado) values('$id_derivaciones', '$id_solicitud', '$id_trabajador', '$fecha_elaboracion', '$id_proveedor', '$id_detalle', '$created_at', '$estado')"); // , '$modalidad_contratacion', '$plazo_entrega', '$forma_adjudicacion', '$multas_retraso', '$forma_pago', '$lugar_entrega'
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
    function editar_requisitos($id_requisitos,$modalidad_contratacion,$plazo_entrega,$forma_adjudicacion,$multas_retraso,$forma_pago,$lugar_entrega)
	{
		$registros = $this->bd->Consulta("UPDATE requisitos set modalidad_contratacion='$modalidad_contratacion', plazo_entrega='$plazo_entrega', forma_adjudicacion='$forma_adjudicacion', multas_retraso='$multas_retraso', forma_pago='$forma_pago', lugar_entrega='$lugar_entrega' WHERE id_requisitos=$id_requisitos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from requisitos $where");
			return $registros;
	}    
    function realizado($id_requisitos)
	{
		$registros = $this->bd->Consulta("update requisitos set estado=realizado where id_requisitos=$id_requisitos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function entregado($id_requisitos)
	{
		$registros = $this->bd->Consulta("update requisitos set estado=entregado where id_requisitos=$id_requisitos");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_requisitos)
	{
		$registros = $this->bd->Consulta("delete from requisitos where id_requisitos=$id_requisitos");
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