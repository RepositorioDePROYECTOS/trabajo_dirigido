<?php 
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/requisitos.php");

referer_permit();
setlocale(LC_TIME,"es_ES");
ini_set('date.timezone','America/La_Paz');


$id_proveedor             = $_POST[id_proveedor];
$id_usuario               = $_POST[id_usuario];
$id_solicitud             = $_POST[id_solicitud];
$id_derivacion            = $_POST[id_derivacion];
$id_detalles              = $_POST[id_detalles];
$tipo_solicitud           = $_POST[tipo_solicitud];
$fecha_elaboracion        = date('Y-m-d');
$fecha                    = date('Y-m-d H:i:s');
$estado                   = 'creado';
$array_id_detalles        = array();
$array_id_detalle         = array();

$requisitos = new requisitos();
$bd = new conexion();

// echo json_encode(array("success" => false, "message" => "id_proveedor: ".$id_proveedor." id_usuario: ".$id_usuario." id_solicitud: ".$id_solicitud." id_derivacion: ".$id_derivacion." id_detalles: ".$id_detalles." tipo_solicitud ".$tipo_solicitud));

$verificaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion = $id_derivacion");
$verificado     = $bd->getFila($verificaciones);
if($verificado[tipo_solicitud] == "material"){
    $detalles = $bd->Consulta("SELECT count(d.id_detalle_material) as id_detalle 
        FROM solicitud_material as s 
        INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
        WHERE s.id_solicitud_material=$id_solicitud");
    $detalle = $bd->getFila($detalles);

    $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_material SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_material=$id_solicitud"); 

} elseif( $verificado[tipo_solicitud] == 'activo') {
    $detalles = $bd->Consulta("SELECT count(d.id_detalle_activo) as id_detalle 
        FROM solicitud_activo as s 
        INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo 
        WHERE s.id_solicitud_activo=$id_solicitud");
    $detalle = $bd->getFila($detalles);

    $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_activo SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_activo =$id_solicitud");

} elseif( $verificado[tipo_solicitud] == 'servicio' ) {
    $detalles = $bd->Consulta("SELECT count(d.id_detalle_servicio) as id_detalle 
        FROM solicitud_servicio as s 
        INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
        WHERE s.id_solicitud_servicio =$id_solicitud");
    $detalle = $bd->getFila($detalles);

    $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET tipo_solicitud='$tipo_solicitud' WHERE id_solicitud_servicio=$id_solicitud");
    
}

$trabajador = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador   WHERE u.id_usuario=$id_usuario");
$t = $bd->getFila($trabajador);
$id_t = $t[id_trabajador];


// // $array = array("proveedor"=>$id_proveedor,"usuario"=>$id_usuario,"solicitud"=>$id_solicitud,"derivacion"=>$id_derivacion,"fecha"=>$fecha_elaboracion,"tipo"=>$tipo_solicitud,"detalles"=>$id_detalles);
// // echo json_encode(array("success" => false, "message" => $array));

 

foreach ($id_detalles as $key) {
    $partes = explode(":", $key);
    $precio = "";
    $detalleId = "";

    if (count($partes) == 2) {
        $detalleId = $partes[0]; // Esto será "1992"
        $precio = $partes[1];
    } else {
        echo json_encode(array("success" => false, "message" => "El formato del string no es válido."));
    }

    if ($verificado[tipo_solicitud] == 'material') {
        $buscar_datos = $bd->Consulta("SELECT cantidad_solicitada FROM detalle_material WHERE id_detalle_material = $detalleId");
        $b_dato  = $bd->getFila($buscar_datos);

        $total = round($b_dato[cantidad_solicitada] * $precio,2);

        $modificar_detalles= $bd->Consulta("UPDATE detalle_material SET precio_unitario='$precio', precio_total='$total' WHERE id_detalle_material=$detalleId");
        // $message = "ID: ".$detalleId." precio: ".$precio." total: ".$total;
        // echo json_encode(array("success" => false, "message" => $message));
    } elseif ($verificado[tipo_solicitud] == 'activo') {
        $buscar_datos = $bd->Consulta("SELECT cantidad_solicitada FROM detalle_activo WHERE id_detalle_activo = $detalleId");
        $b_dato  = $bd->getFila($buscar_datos);

        $total = round($b_dato[cantidad_solicitada] * $precio,2);

        $modificar_detalles= $bd->Consulta("UPDATE detalle_activo SET precio_unitario='$precio', precio_total='$total' WHERE id_detalle_activo=$detalleId");
    } else {
        $buscar_datos = $bd->Consulta("SELECT cantidad_solicitada FROM detalle_servicio WHERE id_detalle_servicio = $detalleId");
        $b_dato  = $bd->getFila($buscar_datos);

        $total = round($b_dato[cantidad_solicitada] * $precio,2);

        $modificar_detalles = $bd->Consulta("UPDATE detalle_servicio SET precio_unitario='$precio', precio_total='$total' WHERE id_detalle_servicio=$detalleId");
    }


    $result = $requisitos->registrar_requisitos($id_derivacion, $id_solicitud, $id_usuario, $fecha_elaboracion, $id_proveedor, $detalleId,  $fecha, $estado); // $modalidad_contratacion, $plazo_entrega, $forma_adjudicacion, $multas_retraso, $forma_pago, $lugar_entrega,
}
if($bd->numFila_afectada() > 0){
    $cantidad_requisitos = $bd->Consulta("SELECT count(id_detalle) as id_detalles FROM requisitos WHERE id_solicitud=$id_solicitud AND id_derivaciones=$id_derivacion");
    $cantidad_requisito  = $bd->getFila($cantidad_requisitos);
    if($cantidad_requisito[id_detalles] == $detalle[id_detalle]){
        // echo json_encode(array("success"=>false,"message"=>"Cantidades Iguales"));
        // $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, created_at, estado) VALUES ($id_derivacion, $id_solicitud, $id_t, '$verificado[tipo_solicitud]', '$fecha', 'proveedor asignado')");
        // $estado_derivacion = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='proveedor asignado' WHERE id_derivacion=$id_derivacion");
    }
    // echo json_encode(array("success" => false, "message" => $cantidad_requisito[id_detalles]."-".$detalle[id_detalle]));
    echo json_encode(array("success" => true, "message" => "Exito al registrar la orden de Compra!"));
} else {
    // echo json_encode(array("success" => false, "message" => "INSERT into requisitos values('','$id_derivacion', '$id_solicitud', '$id_trabajador', '$fecha_elaboracion', '$id_proveedor', '$id_detalle', '$modalidad_contratacion', '$plazo_entrega', '$forma_adjudicacion', '$multas_retraso', '$forma_pago', '$lugar_entrega', '$created_at', '$estado')"));
    echo json_encode(array("success" => false, "message" => "Error al registrar"));
}



