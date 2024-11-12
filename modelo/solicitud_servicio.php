<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class solicitud_servicio
{
	public $id_solicitud_servicio;
    public $nro_solicitud_servicio;
    public $fecha_solicitud;
	public $fecha_registro_adquisiciones;
	public $oficina_solicitante;
	public $unidad_solicitante;
    public $item_solicitante;
    public $nombre_solicitante;
	public $justificativo;
	public $objetivo_contratacion;
	public $observacion;
    public $autorizado_por;
    public $estado_solicitud_servicio;
	public $tipo_solicitud;
    public $id_usuario;
	private $bd;

	function solicitud_servicio()
	{
		$this->bd = new Conexion();
	}
	function registrar_solicitud_servicio($nro_solicitud_servicio,$fecha_solicitud, $oficina_solicitante, $item_solicitante, $nombre_solicitante, $justificativo, $objetivo_contratacion, $autorizado_por, $gerente_area, $estado_solicitud_servicio, $id_usuario)
	{
		$registros = $this->bd->Consulta("INSERT INTO solicitud_servicio (nro_solicitud_servicio,
										fecha_solicitud, 
										oficina_solicitante, 
										item_solicitante, 
										nombre_solicitante,
										justificativo, 
										objetivo_contratacion,
										autorizado_por, 
										gerente_area, 
										estado_solicitud_servicio, 
										id_usuario) values('$nro_solicitud_servicio',
										'$fecha_solicitud', 
										'$oficina_solicitante', 
										'$item_solicitante', 
										'$nombre_solicitante',
										'$justificativo', 
										'$objetivo_contratacion',
										'$autorizado_por', 
										'$gerente_area',  
										'$estado_solicitud_servicio', 
										'$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function definir_tipo_solicitud($id_solicitud_servicio, $tipo_solicitud){
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_solicitud_servicio($id_solicitud_servicio,$justificativo, $objetivo_contratacion, $gerente_area, $autorizado_por)
	{
	   $registros = $this->bd->Consulta("UPDATE solicitud_servicio set justificativo='$justificativo', objetivo_contratacion='$objetivo_contratacion', gerente_area='$gerente_area', autorizado_por='$autorizado_por' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_solicitud_servicio($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("SELECT * from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio");
		$registro = $this->bd->getFila($registros);

		$this->id_solicitud_servicio = $registro[id_solicitud_servicio];
		$this->nro_solicitud_servicio = $registro[nro_solicitud_servicio];
		$this->fecha_solicitud = $registro[fecha_solicitud];
		$this->fecha_registro_adquisiciones = $registro[fecha_registro_adquisiciones];
		$this->oficina_solicitante = $registro[oficina_solicitante];
		$this->item_solicitante = $registro[item_solicitante];
		$this->nombre_solicitante = $registro[nombre_solicitante];
		$this->observacion = $registro[observacion];
		$this->autorizado_por = $registro[autorizado_por];
		$this->estado_solicitud_servicio = $registro[estado_solicitud_servicio];
		$this->id_usuario = $registro[id_usuario];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("SELECT * from solicitud_servicio $where");
			return $registros;
	}
	function verificar($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='VERIFICADO' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function autorizar($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='APROBADO' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function autorizar_ga($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='VISTO BUENO G.A.' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function rechazar($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='RECHAZADO' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar_ga($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='SIN VISTO BUENO G.A.' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function rechazar_solicitud($id_solicitud_servicio, $observacion)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='RECHAZADO', observacion='$observacion' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function en_adquisicion($id_solicitud_servicio, $estado, $fecha_registro_adquisiciones)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='$estado', fecha_registro_adquisiciones='$fecha_registro_adquisiciones' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function presupuestar($id_solicitud_servicio, $estado)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_servicio set estado_solicitud_servicio='$estado' where id_solicitud_servicio=$id_solicitud_servicio");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_solicitud_servicio)
	{
		$registros = $this->bd->Consulta("DELETE from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio");
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