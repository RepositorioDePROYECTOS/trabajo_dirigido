<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class descargo_refrigerio
{
	public $id_descargo_refrigerio;
	public $mes;
	public $gestion;
	public $monto_descargo;
	public $monto_refrigerio;
	public $retencion;
	public $total_refrigerio;
	public $id_asistencia_refrigerio;
	private $bd;

	function descargo_refrigerio()
	{
		$this->bd = new conexion();
	}
	function registrar_descargo_refrigerio($mes, $gestion, $monto_descargo, $monto_refrigerio, $retencion, $total_refrigerio, $id_asistencia_refrigerio)
	{
		$registros = $this->bd->Consulta("insert into descargo_refrigerio values('','$mes', '$gestion', '$monto_descargo', '$monto_refrigerio', '$retencion',  '$total_refrigerio', '$id_asistencia_refrigerio')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_descargo_refrigerio($id_descargo_refrigerio, $monto_descargo, $retencion, $total_refrigerio)
	{
		$registros = $this->bd->Consulta("update descargo_refrigerio set monto_descargo='$monto_descargo', retencion='$retencion', total_refrigerio=$total_refrigerio where id_descargo_refrigerio=$id_descargo_refrigerio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_descargo_refrigerio)
	{
		$registros = $this->bd->Consulta("delete from descargo_refrigerio where id_descargo_refrigerio=$id_descargo_refrigerio ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_planilla($mes, $gestion)
	{
		$registros = $this->bd->Consulta("delete from descargo_refrigerio where mes=$mes and gestion=$gestion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_descargo_refrigerio($id_descargo_refrigerio)
	{
		$registros = $this->bd->Consulta("select * from descargo_refrigerio where id_descargo_refrigerio=$id_descargo_refrigerio");
		$registro = $this->bd->getFila($registros);

		$this->id_descargo_refrigerio = $registro[id_descargo_refrigerio];
		$this->mes = $registro[mes];
		$this->gestion = $registro[gestion];
		$this->monto_descargo = $registro[monto_descargo];
		$this->monto_refrigerio = $registro[monto_refrigerio];
		$this->retencion = $registro[retencion];
		$this->total_refrigerio = $registro[total_refrigerio];
		$this->id_asistencia_refrigerio = $registro[id_asistencia_refrigerio];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from descargo_refrigerio $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>