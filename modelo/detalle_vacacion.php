<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class detalle_vacacion
{
	public $id_detalle_vacacion;
	public $gestion_inicio;
	public $gestion_fin;
	public $fecha_calculo;
	public $cantidad_dias;
	public $dias_utilizados;
	public $id_vacacion;
	private $bd;

	function detalle_vacacion()
	{
		$this->bd = new conexion();
	}
	function registrar_detalle_vacacion($gestion_inicio, $gestion_fin, $fecha_calculo, $cantidad_dias, $dias_utilizados, $id_vacacion)
	{
		$registros = $this->bd->Consulta("INSERT into detalle_vacacion values('','$gestion_inicio', '$gestion_fin', '$fecha_calculo', '$cantidad_dias', '$dias_utilizados', '$id_vacacion')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_detalle_vacacion($id_detalle_vacacion, $cantidad_dias, $dias_utilizados)
	{
		$registros = $this->bd->Consulta("update detalle_vacacion set cantidad_dias='$cantidad_dias', dias_utilizados='$dias_utilizados' where id_detalle_vacacion=$id_detalle_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_detalle_vacacion)
	{
		$registros = $this->bd->Consulta("delete from detalle_vacacion where id_detalle_vacacion=$id_detalle_vacacion ");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_dias_utilizados($id_detalle_vacacion, $cantidad_dias)
	{
		$registros = $this->bd->Consulta("select * from detalle_vacacion where id_detalle_vacacion=$id_detalle_vacacion");
		$registro = $this->bd->getFila($registros);
		$dias_utilizados = $registro[dias_utilizados] + $cantidad_dias;
		$registros = $this->bd->Consulta("update detalle_vacacion set dias_utilizados='$dias_utilizados' where id_detalle_vacacion=$id_detalle_vacacion");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	
	function get_detalle_vacacion($id_detalle_vacacion)
	{
		$registros = $this->bd->Consulta("select * from detalle_vacacion where id_detalle_vacacion=$id_detalle_vacacion");
		$registro = $this->bd->getFila($registros);

		$this->id_detalle_vacacion = $registro[id_detalle_vacacion];
		$this->gestion_inicio = $registro[gestion_inicio];
		$this->gestion_fin = $registro[gestion_fin];
		$this->fecha_calculo = $registro[fecha_calculo];
		$this->cantidad_dias = $registro[cantidad_dias];
		$this->dias_utilizados = $registro[dias_utilizados];
		$this->id_vacacion = $registro[id_vacacion];
	}
    
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from detalle_vacacion $where");
			return $registros;
	}

	function update_dias($id_detalle_vacacion_find, $cantidad_dias, $dias_utilizados, $dias_solicitados ,$dias_ejecutados) {
		$res = $dias_utilizados - $dias_solicitados + $dias_ejecutados;
		$registros = $this->bd->Consulta("UPDATE detalle_vacacion SET dias_utilizados = '$res' WHERE id_detalle_vacacion = $id_detalle_vacacion_find");
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