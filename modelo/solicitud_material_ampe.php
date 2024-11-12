<?php
if(!class_exists("conexion"))
	include ("conexion.php");
class solicitud_material_ampe
{
	public $id_solicitud_material;
    public $nro_solicitud_material;
    public $fecha_solicitud;
	public $oficina_solicitante;
	public $programa_solicitud_material;
	public $actividad_solicitud_material;
	public $unidad_solicitante;
    public $item_solicitante;
    public $nombre_solicitante;
	public $justificativo;
	public $justificacion;
	public $onjetivo_contratacion;
    public $autorizado_por;
    public $gerente_area;
    public $observacion;
    public $fecha_despacho;
    public $existencia_material;
	public $visto_bueno;
    public $estado_solicitud_material;
	public $tipo_solicitud;
    public $id_usuario;
	private $bd;

	function solicitud_material_ampe()
	{
		$this->bd = new Conexion();
	}
	function registrar_solicitud_material($nro_solicitud_material,
		$fecha_solicitud, 
		$programa_solicitud_material, 
		$actividad_solicitud_material, 
		$oficina_solicitante, 
		$item_solicitante, 
		$nombre_solicitante, 
		$justificativo, 
		$onjetivo_contratacion,
		$autorizado_por, 
		$visto_bueno, 
		$gerente_area, 
		$existencia_material, 
		$estado_solicitud_material, 
		$id_usuario)
	{
		$registros = $this->bd->Consulta("INSERT INTO solicitud_material (
										nro_solicitud_material,
										fecha_solicitud, 
										programa_solicitud_material,
										actividad_solicitud_material,
										oficina_solicitante,
										item_solicitante, 
										nombre_solicitante,
										justificativo,
										objetivo_contratacion,
										autorizado_por, 
										visto_bueno,
										gerente_area, 
										existencia_material, 
										estado_solicitud_material, 
										id_usuario
										) values(
										'$nro_solicitud_material',
										'$fecha_solicitud', 
										'$programa_solicitud_material', 
										'$actividad_solicitud_material',  
										'$oficina_solicitante',
										'$item_solicitante', 
										'$nombre_solicitante',
										'$justificativo',
										'$onjetivo_contratacion',
										'$autorizado_por', 
										'$visto_bueno', 
										'$gerente_area', 
										'$existencia_material', 
										'$estado_solicitud_material', 
										'$id_usuario')");
		if($this->bd->numFila_afectada()>0)
			return true;
		else
			return false;
	}
	function registrar_solicitud_material_no($nro_solicitud_material, 
		$fecha_solicitud,
		$unidad_solicitante, 
		$item_solicitante,
		$nombre_solicitante, 
		$justificacion, 
		$objetivo_contratacion, 
		$existencia_material, 
		$estado_solicitud_material, 
		$id_usuario){
		$registros = $this->bd->Consulta("INSERT INTO solicitud_material (
			nro_solicitud_material,
			fecha_solicitud,
			programa_solicitud_activo,
			actividad_solicitud_material, 
			unidad_solicitante, 
			item_solicitante,
			nombre_solicitante,
			justificativo, 
			objetivo_contratacion,
			existencia_material, 
			estado_solicitud_material, 
			id_usuario
			) values(
			'$nro_solicitud_material',
			'$fecha_solicitud',
			'$unidad_solicitante',
			'$item_solicitante', 
			'$nombre_solicitante',
			'$justificacion', 
			'$objetivo_contratacion',
			'$existencia_material', 
			'$estado_solicitud_material', 
			'$id_usuario')");
		if($this->bd->numFila_afectada()>0)
		return true;
		else
		return false;
	}
	function definir_tipo_solicitud($id_solicitud_material, $tipo_solicitud){
		$registros = $this->bd->Consulta("UPDATE solicitud_material SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_solicitud_material($id_solicitud_material, $justificativo, $gerente_area, $autorizado_por)
	{
	   $registros = $this->bd->Consulta("update solicitud_material set justificativo='$justificativo', gerente_area='$gerente_area', autorizado_por='$autorizado_por' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function modificar_solicitud_material_no($id_solicitud_material,$unidad_solicitante, $objetivo_contratacion, $justificacion)
	{
	   $registros = $this->bd->Consulta("update solicitud_material set unidad_solicitante='$unidad_solicitante', objetivo_contratacion='$objetivo_contratacion', justificativo='$justificacion' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function get_solicitud_material($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("select * from solicitud_material where id_solicitud_material=$id_solicitud_material");
		$registro = $this->bd->getFila($registros);

		$this->id_solicitud_material = $registro[id_solicitud_material];
		$this->nro_solicitud_material = $registro[nro_solicitud_material];
		$this->fecha_solicitud = $registro[fecha_solicitud];
		$this->oficina_solicitante = $registro[oficina_solicitante];
		$this->item_solicitante = $registro[item_solicitante];
		$this->nombre_solicitante = $registro[nombre_solicitante];
		$this->justificativo = $registro[justificativo];
		$this->autorizado_por = $registro[autorizado_por];
		$this->gerente_area = $registro[gerente_area];
		$this->observacion = $registro[observacion];
		$this->existencia_material = $registro[existencia_material];
		$this->fecha_despacho = $registro[fecha_despacho];
		$this->estado_solicitud_material = $registro[estado_solicitud_material];
		$this->id_usuario = $registro[id_usuario];
	}
	function get_all($criterio)
	{
		if(empty($criterio)) $where = ""; else $where = " where $criterio";
		$registros = $this->bd->Lista("select * from solicitud_material $where");
			return $registros;
	}
	function verificar($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='VERIFICADO' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function autorizar($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='APROBADO' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function autorizar_ga($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='VISTO BUENO G.A.' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function rechazar($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='RECHAZADO' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar_ga($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='SIN VISTO BUENO G.A.' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function rechazar_solicitud($id_solicitud_material, $observacion)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='RECHAZADO', observacion='$observacion' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function estado_sin_existencia($id_solicitud_material, $fecha_despacho)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='SIN EXISTENCIA', fecha_despacho='$fecha_despacho' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}

	function en_adquisicion($id_solicitud_material, $estado, $fecha_registro_adquisiciones)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='$estado', fecha_registro_adquisiciones='$fecha_registro_adquisiciones' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
	function presupuestar($id_solicitud_material, $estado)
	{
		$registros = $this->bd->Consulta("update solicitud_material set estado_solicitud_material='$estado' where id_solicitud_material=$id_solicitud_material");
		if($this->bd->numFila_afectada($registros)>0)
			return true;
		else
			return false;
	}
    function eliminar($id_solicitud_material)
	{
		$registros = $this->bd->Consulta("delete from solicitud_material where id_solicitud_material=$id_solicitud_material");
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