<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class conf_asistencia
{
	public $id_conf_asistencia;
	public $nombre_asistencia;
	public $inicio_manana;
	public $fin_manana;
	public $inicio_tarde;
	public $fin_tarde;
	public $estado;
	private $bd;

	function conf_asistencia()
	{
		$this->bd = new conexion();
	}
	function registrar_conf_asistencia($nombre_asistencia, $inicio_manana, $fin_manana, $inicio_tarde, $fin_tarde, $estado)
	{
		$registros = $this->bd->Consulta("INSERT INTO conf_asistencia (nombre_asistencia, inicio_manana, fin_manana ,inicio_tarde, fin_tarde, estado) VALUES ('$nombre_asistencia', '$inicio_manana', '$fin_manana', '$inicio_tarde', '$fin_tarde','$estado')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_conf_asistencia($id_conf_asistencia, $nombre_asistencia, $estado)
	{
		$registros = $this->bd->Consulta("UPDATE conf_asistencia SET nombre_asistencia='$nombre_asistencia', estado='$estado' WHERE id_conf_asistencia=$id_conf_asistencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_estado_habilitado_conf_asistencia($id_conf_asistencia)
	{
		$registros = $this->bd->Consulta("UPDATE conf_asistencia SET estado='HABILITADO' WHERE id_conf_asistencia=$id_conf_asistencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_estado_inhabilitado_conf_asistencia($id_conf_asistencia) 
	{
		$registros = $this->bd->Consulta("UPDATE conf_asistencia SET estado='INHABILITADO' WHERE id_conf_asistencia=$id_conf_asistencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_conf_asistencia)
	{
		$registros = $this->bd->Consulta("DELETE FROM conf_asistencia WHERE id_conf_asistencia=$id_conf_asistencia");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_conf_asistencia_by_id($id_conf_asistencia)
	{
		$registros = $this->bd->Consulta("SELECT * FROM conf_asistencia WHERE id_conf_asistencia=$id_conf_asistencia");
		return $this->bd->getFila($registros);
	}
	function get_conf_asistencia($id_conf_asistencia)
	{
		$registros = $this->bd->Consulta("SELECT * FROM conf_asistencia WHERE id_conf_asistencia=$id_conf_asistencia");
		$registro = $this->bd->getFila($registros);

		$this->id_conf_asistencia = $registro[id_conf_asistencia];
		$this->nombre_asistencia  = $registro[nombre_asistencia];
        $this->inicio_manana      = $registro[inicio_manana];
        $this->fin_manana         = $registro[fin_manana];
        $this->inicio_tarde       = $registro[inicio_tarde];
        $this->fin_tarde          = $registro[fin_tarde];
		$this->estado             = $registro[estado];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("SELECT * FROM conf_asistencia $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>