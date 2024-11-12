<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class solicitud_activo_ampe
{
	public $id_solicitud_activo;
	public $programa_solicitud_activo;
	public $actividad_solicitud_activo;
    public $nro_solicitud_activo;
    public $fecha_solicitud;
	public $oficina_solicitante;
    public $item_solicitante;
    public $nombre_solicitante;
	public $justificativo;
	public $objetivo_contratacion;
    public $autorizado_por;
    public $gerente_area;
    public $observacion;
    public $fecha_despacho;
    public $existencia_activo;
	public $visto_bueno;
    public $estado_solicitud_activo;
	public $tipo_solicitud;
    public $id_usuario;
	private $bd;

	function solicitud_activo_ampe()
	{
		$this->bd = new Conexion();
	}
	// function __construct()
	// {
	// 	$this->bd = new Conexion();
	// 	if (!$this->bd) {
	// 		die("Database connection error."); // Add appropriate error handling here
	// 	}
	// }
	function registrar_solicitud_activo(
		$nro_solicitud_activo,
		$fecha_solicitud, 
		$programa_solicitud_activo, 
		$actividad_solicitud_activo, 
		$oficina_solicitante, 
		$item_solicitante, 
		$nombre_solicitante, 
		$justificativo, 
		$objetivo_contratacion,
		$autorizado_por, 
		$visto_bueno, 
		$gerente_area, 
		$existencia_activo, 
		$estado_solicitud_activo, 
		$id_usuario) {
		$registros = $this->bd->Consulta("INSERT INTO solicitud_activo (
										nro_solicitud_activo,
										fecha_solicitud, 
										programa_solicitud_activo,
										actividad_solicitud_activo,
										oficina_solicitante, 
										item_solicitante, 
										nombre_solicitante,
										justificativo, 
										objetivo_contratacion,
										autorizado_por, 
										visto_bueno,
										gerente_area, 
										existencia_activo, 
										estado_solicitud_activo, 
										id_usuario) values (
										'$nro_solicitud_activo',
										'$fecha_solicitud',  
										'$programa_solicitud_activo',  
										'$actividad_solicitud_activo',  
										'$oficina_solicitante', 
										'$item_solicitante', 
										'$nombre_solicitante',
										'$justificativo', 
										'$objetivo_contratacion',
										'$autorizado_por', 
										'$visto_bueno',
										'$gerente_area', 
										'$existencia_activo', 
										'$estado_solicitud_activo', 
										'$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function registrar_solicitud_activo_no($nro_solicitud_activo, $programa_solicitud_activo, $actividad_solicitud_activo,$fecha_solicitud, $unidad_solicitante, $item_solicitante,$nombre_solicitante, $justificativo, $objetivo_contratacion, $existencia_activo, $estado_solicitud_activo, $id_usuario)
	{
		$registros = $this->bd->Consulta("INSERT INTO solicitud_activo (nro_solicitud_activo,
										fecha_solicitud,
										programa_solicitud_activo,
										actividad_solicitud_activo, 
										unidad_solicitante, 
										item_solicitante, 
										nombre_solicitante,
										justificativo, 
										objetivo_contratacion, 
										existencia_activo, 
										estado_solicitud_activo, 
										id_usuario) values('$nro_solicitud_activo',
										'$fecha_solicitud', 
										'$programa_solicitud_activo', 
										'$actividad_solicitud_activo', 
										'$unidad_solicitante', 
										'$item_solicitante', 
										'$nombre_solicitante',
										'$justificativo', 
										'$objetivo_contratacion', 
										'$existencia_activo', 
										'$estado_solicitud_activo', 
										'$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function definir_tipo_solicitud($id_solicitud_activo, $tipo_solicitud){
		$registros = $this->bd->Consulta("UPDATE solicitud_activo SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_solicitud_activo($id_solicitud_activo,$justificativo, $gerente_area, $autorizado_por)
	{
	   $registros = $this->bd->Consulta("UPDATE solicitud_activo set justificativo='$justificativo', gerente_area='$gerente_area', autorizado_por='$autorizado_por' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_solicitud_activo_no($id_solicitud_activo,$unidad_solicitante, $objetivo_contratacion, $justificacion)
	{
	   $registros = $this->bd->Consulta("UPDATE solicitud_activo set unidad_solicitante='$unidad_solicitante', objetivo_contratacion='$objetivo_contratacion', justificativo='$justificacion' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_solicitud_activo($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("select * from solicitud_activo where id_solicitud_activo=$id_solicitud_activo");
		$registro = $this->bd->getFila($registros);

		$this->id_solicitud_activo = $registro[id_solicitud_activo];
		$this->nro_solicitud_activo = $registro[nro_solicitud_activo];
		$this->fecha_solicitud = $registro[fecha_solicitud];
		$this->oficina_solicitante = $registro[oficina_solicitante];
		$this->item_solicitante = $registro[item_solicitante];
		$this->nombre_solicitante = $registro[nombre_solicitante];
		$this->justificativo = $registro[justificativo];
		$this->autorizado_por = $registro[autorizado_por];
		$this->gerente_area = $registro[gerente_area];
		$this->observacion = $registro[observacion];
		$this->existencia_activo = $registro[existencia_activo];
		$this->fecha_despacho = $registro[fecha_despacho];
		$this->estado_solicitud_activo = $registro[estado_solicitud_activo];
		$this->id_usuario = $registro[id_usuario];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from solicitud_activo $where");
			return $registros;
	}
	function verificar($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='VERIFICADO' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function autorizar($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='APROBADO' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function autorizar_ga($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='VISTO BUENO G.A.' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function rechazar($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='RECHAZADO' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar_ga($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='RECHAZADO G.A.' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar_solicitud($id_solicitud_activo, $observacion)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='RECHAZADO', observacion='$observacion' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function estado_sin_existencia($id_solicitud_activo, $fecha_despacho)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='SIN EXISTENCIA', fecha_despacho='$fecha_despacho' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function en_adquisicion($id_solicitud_activo, $estado, $fecha_registro_adquisiciones)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='$estado', fecha_registro_adquisiciones='$fecha_registro_adquisiciones' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function presupuestar($id_solicitud_activo, $estado)
	{
		$registros = $this->bd->Consulta("UPDATE solicitud_activo set estado_solicitud_activo='$estado' where id_solicitud_activo=$id_solicitud_activo");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_solicitud_activo)
	{
		$registros = $this->bd->Consulta("delete from solicitud_activo where id_solicitud_activo=$id_solicitud_activo");
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
