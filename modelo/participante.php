<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class Postulante
{
	public $id_postulante;
	public $nombre_postulante;
	public $ci_postulante;
	public $telefono_portulante;
	public $correo_postulante;
	private $bd;

	function postulante()
	{
		$this->bd = new conexion();
	}
	function registrar_postulante($nombre_postulante, $ci_postulante, $telefono_portulante, $correo_postulante)
	{
		$registros = $this->bd->Consulta("INSERT into postulante values('', '$nombre_postulante', '$ci_postulante', '$telefono_portulante','$correo_postulante')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function modificar_postulante($id_postulante, $nombre_postulante, $ci_postulante, $telefono_postulante, $correo_postulante)
	{
		$registros = $this->bd->Consulta("UPDATE postulante set nombre_postulante='$nombre_postulante', ci_postulante='$ci_postulante', telefono_postulante='$telefono_postulante', correo_postulante='$correo_postulante' where id_postulante = $id_postulante");
		// echo "UPDATE postulante set nombre_postulante='$nombre_postulante', ci_postulante='$ci_postulante', telefono_postulante='$telefono_postulante', correo_postulante='$correo_postulante' where id_postulante = $id_postulante";
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function eliminar($id_postulante)
	{
		$registros = $this->bd->Consulta("DELETE from postulante where id_postulante=$id_postulante");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_postulante($id_postulante)
	{
		$registros = $this->bd->Consulta("SELECT * from postulante where id_postulante=$id_postulante");
		$registro = $this->bd->getFila($registros);

		$this->id_postulante = $registro[id_postulante];
		$this->nombre_postulante = $registro[nombre_postulante];
		$this->ci_postulante = $registro[ci_postulante];
		$this->telefono_portulante = $registro[telefono_portulante];
		$this->correo_postulante = $registro[correo_postulante];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " $criterio";
		$registros = $this->bd->Lista("select * from postulante $where");
			return $registros;
	}
	function __destroy()
	{
		$registros = $this->bd->Cerrar();
	}
}
 
?>