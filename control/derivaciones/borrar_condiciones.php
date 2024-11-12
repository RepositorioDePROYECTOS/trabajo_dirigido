<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");

    referer_permit();
    // date_default_timezone_set('America/La_Paz');
    setlocale(LC_TIME, "es_ES");
    ini_set('date.timezone', 'America/La_Paz');
    $bd = new conexion();
    $id_solicitud              = $_GET[id_solicitud];
    $id_proveedor              = $_GET[id_proveedor];
    // $array=array("modalidad: "=>$modalidad_contratacion,"plazo: "=>$plazo_entrega,"adjudicacion: "=>$forma_adjudicacion,"multas: "=>$multas_retraso,"pago: "=>$forma_pago,"lugar: "=>$lugar_entrega,"usuario: "=>$id_usuario,"solicitud: "=>$id_solicitud,"proveedor: "=>$id_proveedor,"tipo: "=>$tipo);
    // print_r($array);
    $requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor");
    while($requisito = $bd->getFila($requisitos)){
        $actualizar = $bd->Consulta("UPDATE requisitos SET modalidad_contratacion=NULL, plazo_entrega=NULL, forma_adjudicacion=NULL, multas_retraso=NULL, forma_pago=NULL, lugar_entrega=NULL WHERE id_requisitos=$requisito[id_requisitos] ");
    }
    if($bd->numFila_afectada() > 0){
        echo "Exito, Datos registrados.";
    } else {
        echo "Ocurri&oacute; un Error.";
    }
?>