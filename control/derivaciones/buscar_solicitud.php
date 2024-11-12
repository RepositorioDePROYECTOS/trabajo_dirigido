<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
$id   = $_GET[id];
$tipo = $_GET[tipo];
$bd = new conexion();
if ($tipo === "material") {
    $result = $bd->Consulta("SELECT 
        s.id_solicitud_material,
        s.nro_solicitud_material,
        s.fecha_solicitud,
        s.oficina_solicitante,
        s.unidad_solicitante,
        s.item_solicitante,
        s.nombre_solicitante,
        s.justificativo,
        s.autorizado_por,
        s.existencia_material,
        s.estado_solicitud_material, 
        dm.id_detalle_material,
        r.id_requisitos,
        r.id_detalle,
        r.id_proveedor
        FROM solicitud_material s 
        INNER JOIN usuario u ON u.id_usuario=s.id_usuario 
        INNER JOIN trabajador t ON t.id_trabajador=u.id_trabajador 
        INNER JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_material
        INNER JOIN detalle_material dm ON dm.id_solicitud_material = s.id_solicitud_material
        INNER JOIN requisitos r ON r.id_solicitud=s.id_solicitud_material AND r.id_derivaciones=d.id_derivacion
        WHERE s.id_solicitud_material = $id
        LIMIT 1
        ");
    // $guardar = $bd->Consulta("SELECT * 
    //     FROM procedimientos p 
    //     INNER JOIN derivaciones d ON p.id_derivacion = d.id_derivacion
    //     -- INNER JOIN solicitud_material s ON s.id_solicitud_material = d.id_solicitud
    //     WHERE d.id_solicitud = $id");
} elseif ($tipo === "activo") {
    $result = $bd->Consulta("SELECT 
        s.id_solicitud_activo,
        s.nro_solicitud_activo,
        s.fecha_solicitud,
        s.oficina_solicitante,
        s.unidad_solicitante,
        s.item_solicitante,
        s.nombre_solicitante,
        s.justificativo,
        s.autorizado_por,
        s.existencia_activo,
        s.estado_solicitud_activo, 
        dm.id_detalle_activo,
        r.id_requisitos,
        r.id_detalle,
        r.id_proveedor
        FROM solicitud_activo s 
        INNER JOIN usuario u ON u.id_usuario=s.id_usuario 
        INNER JOIN trabajador t ON t.id_trabajador=u.id_trabajador 
        INNER JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_activo
        INNER JOIN detalle_activo dm ON dm.id_solicitud_activo = s.id_solicitud_activo
        INNER JOIN requisitos r ON r.id_solicitud=s.id_solicitud_activo AND r.id_derivaciones=d.id_derivacion
        WHERE s.id_solicitud_activo = $id
        LIMIT 1
        ");
    // $guardar = $bd->Consulta("SELECT * 
    // FROM procedimientos p 
    // INNER JOIN derivaciones d ON p.id_derivacion = d.id_derivacion
    // -- INNER JOIN solicitud_activo s ON s.id_solicitud_activo = d.id_solicitud
    // WHERE d.id_solicitud = $id");
} else {
    $result = $bd->Consulta("SELECT 
        s.id_solicitud_servicio,
        s.nro_solicitud_servicio,
        s.fecha_solicitud,
        s.oficina_solicitante,
        s.unidad_solicitante,
        s.item_solicitante,
        s.nombre_solicitante,
        s.justificativo,
        s.autorizado_por,
        s.estado_solicitud_servicio, 
        dm.id_detalle_servicio,
        r.id_requisitos,
        r.id_detalle,
        r.id_proveedor
        FROM solicitud_servicio s 
        INNER JOIN usuario u ON u.id_usuario=s.id_usuario 
        INNER JOIN trabajador t ON t.id_trabajador=u.id_trabajador 
        INNER JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        INNER JOIN detalle_servicio dm ON dm.id_solicitud_servicio = s.id_solicitud_servicio
        INNER JOIN requisitos r ON r.id_solicitud=s.id_solicitud_servicio AND r.id_derivaciones=d.id_derivacion
        WHERE s.id_solicitud_servicio = $id
        LIMIT 1
        ");
}
$guardar = $bd->Consulta("SELECT * 
        FROM procedimientos p 
        INNER JOIN derivaciones d ON p.id_derivacion = d.id_derivacion
        WHERE d.id_solicitud = $id");
$registros = $bd->getFila($result);
$guardado = $bd->getFila($guardar);
echo json_encode(array("data" => $registros, "guardar" => $guardado, "consulta" => "SELECT * FROM procedimientos p INNER JOIN derivaciones d ON p.id_derivacion = d.id_derivacion WHERE d.id_solicitud = $id"));
