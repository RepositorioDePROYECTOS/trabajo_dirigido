<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class Entrevista
{
	public $id_convocatoria;
	public $nombre_convocatoria;
	public $mes_convocatoria;
	public $gestion_convocatoria;
	public $correo_convocatoria;
	private $bd;

	function entrevista()
	{
		$this->bd = new conexion();
	}
	function registrar_convocatoria($nombre_convocatoria, $mes_convocatoria, $gestion_convocatoria)
	{
		$registros = $this->bd->Consulta("INSERT into convocatoria values('', '$nombre_convocatoria', '$mes_convocatoria', '$gestion_convocatoria')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function registrar_preguntas($id_convocatoria, $enunciado_preguntas, $calificacion_preguntas) {
		$registros = $this->bd->Consulta("INSERT into preguntas_convocatoria values('', '$enunciado_preguntas', '$calificacion_preguntas', '$id_convocatoria')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_convocatoria($id_convocatoria, $nombre_convocatoria, $mes_convocatoria, $gestion_convocatoria)
	{
		$registros = $this->bd->Consulta("UPDATE convocatoria set nombre_convocatoria='$nombre_convocatoria', mes_convocatoria='$mes_convocatoria', gestion_convocatoria='$gestion_convocatoria' where id_convocatoria = $id_convocatoria");
		// echo "UPDATE convocatoria set nombre_convocatoria='$nombre_convocatoria', mes_convocatoria='$mes_convocatoria', telefono_convocatoria='$telefono_convocatoria', correo_convocatoria='$correo_convocatoria' where id_convocatoria = $id_convocatoria";
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_convocatoria)
	{
		$registros = $this->bd->Consulta("DELETE from convocatoria where id_convocatoria=$id_convocatoria");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar_preguntas($id){
		$registros = $this->bd->Consulta("DELETE from preguntas_convocatoria where id_preguntas=$id");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_convocatoria($id_convocatoria)
	{
		$registros = $this->bd->Consulta("SELECT * from convocatoria where id_convocatoria=$id_convocatoria");
		$registro = $this->bd->getFila($registros);

		$this->id_convocatoria = $registro[id_convocatoria];
		$this->nombre_convocatoria = $registro[nombre_convocatoria];
		$this->mes_convocatoria = $registro[mes_convocatoria];
		$this->gestion_convocatoria = $registro[gestion_convocatoria];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from convocatoria $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>