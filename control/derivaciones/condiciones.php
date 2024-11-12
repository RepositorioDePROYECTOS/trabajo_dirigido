<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    include("../../modelo/solicitud_servicio.php");
    include("../../modelo/solicitud_activo.php");
    include("../../modelo/solicitud_material.php");

    referer_permit();
    // date_default_timezone_set('America/La_Paz');
    setlocale(LC_TIME, "es_ES");
    ini_set('date.timezone', 'America/La_Paz');
    $bd = new conexion();

    $modalidad_contratacion    = ($_POST[modalidad_contratacion] != '') ? utf8_decode($_POST[modalidad_contratacion]) : '';
    $plazo_entrega             = ($_POST[plazo_entrega] != '') ? utf8_decode($_POST[plazo_entrega]) : '';
    $forma_adjudicacion        = ($_POST[forma_adjudicacion] != '') ? utf8_decode($_POST[forma_adjudicacion]) : '';
    $multas_retraso            = ($_POST[multas_retraso] != '') ? utf8_decode($_POST[multas_retraso]) : '';
    $forma_pago                = ($_POST[forma_pago] != '') ? utf8_decode($_POST[forma_pago]) : '';
    $lugar_entrega             = ($_POST[lugar_entrega] != '') ? utf8_decode($_POST[lugar_entrega]) : '';
    $id_usuario                = $_POST[id_usuario];
    $id_solicitud              = $_POST[id_solicitud];
    $id_proveedor              = $_POST[id_proveedor];
    $tipo                      = $_POST[tipo];
    $fecha                     = date('Y-m-d H:i:s');

    $verificaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud = $id_solicitud AND tipo_solicitud = '$tipo'");
    $verificado     = $bd->getFila($verificaciones);

    $trabajador = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador   WHERE u.id_usuario=$id_usuario");
    $t = $bd->getFila($trabajador);
    $id_t = $t[id_trabajador];

    if($tipo == "material"){
        $detalles = $bd->Consulta("SELECT count(d.id_detalle_material) as id_detalle 
            FROM solicitud_material as s 
            INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
            WHERE s.id_solicitud_material=$id_solicitud");
        $detalle = $bd->getFila($detalles);
    } elseif( $tipo == 'activo') {
        $detalles = $bd->Consulta("SELECT count(d.id_detalle_activo) as id_detalle 
            FROM solicitud_activo as s 
            INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo 
            WHERE s.id_solicitud_activo=$id_solicitud");
        $detalle = $bd->getFila($detalles);
    } elseif( $tipo == 'servicio' ) {
        $detalles = $bd->Consulta("SELECT count(d.id_detalle_servicio) as id_detalle 
            FROM solicitud_servicio as s 
            INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
            WHERE s.id_solicitud_servicio =$id_solicitud");
        $detalle = $bd->getFila($detalles);
    }
    
    $cantidad_requisitos = $bd->Consulta("SELECT count(id_detalle) as id_detalles FROM requisitos WHERE id_solicitud=$id_solicitud AND id_derivaciones=$verificado[id_derivacion] AND forma_pago IS NOT NULL");
    $cantidad_requisito  = $bd->getFila($cantidad_requisitos);
    
    // if($cantidad_requisito[id_detalles] == $detalle[id_detalle]){
        if( $tipo == "material"){
            $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_material SET estado_solicitud_material='PROVEEDOR ASIGNADO' WHERE id_solicitud_material=$id_solicitud"); 
        } elseif( $tipo == "activo" ){
            $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_activo SET estado_solicitud_activo='PROVEEDOR ASIGNADO' WHERE id_solicitud_activo =$id_solicitud");
        } elseif( $tipo == "servicio" ){
            $cambio_tipo_solicitud = $bd->Consulta("UPDATE solicitud_servicio SET estado_solicitud_servicio='PROVEEDOR ASIGNADO' WHERE id_solicitud_servicio=$id_solicitud");
        }
        $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($verificado[id_derivacion], $id_solicitud, $id_t, '$verificado[tipo_solicitud]', 'proveedor asignado')");
        $estado_derivacion = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='proveedor asignado' WHERE id_derivacion=$verificado[id_derivacion]");
    // }

    $requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor");
    while($requisito = $bd->getFila($requisitos)){
        $actualizar = $bd->Consulta("UPDATE requisitos SET modalidad_contratacion='$modalidad_contratacion', plazo_entrega='$plazo_entrega', forma_adjudicacion='$forma_adjudicacion', multas_retraso='$multas_retraso', forma_pago='$forma_pago', lugar_entrega='$lugar_entrega' WHERE id_requisitos=$requisito[id_requisitos] ");
    }
    if($bd->numFila_afectada() > 0){
        echo "Exito, Datos registrados.";
    } else {
        echo "Ocurri&oacute; un Error.";
    }
?>