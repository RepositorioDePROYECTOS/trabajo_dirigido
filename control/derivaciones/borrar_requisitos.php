<?php 
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    include("../../modelo/requisitos.php");
    
    referer_permit();
    setlocale(LC_TIME,"es_ES");
    ini_set('date.timezone','America/La_Paz');
    $requisitos = new requisitos();
    $bd = new conexion();

    $id_solicitud    = $_GET[id_solicitud];
    $id_proveedor    = $_GET[id_proveedor];
    $tipo            = $_GET[tipo];
    $id_derivacion   = $_GET[id_derivacion];

    $buscar = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor AND id_derivaciones=$id_derivacion");
    while($b = $bd->getFila($buscar)){
        $borrar = $bd->Consulta("DELETE FROM requisitos WHERE id_requisitos=$b[id_requisitos]");
    }
    if($bd->numFila_afectada() > 0){
        echo json_encode(array("success"=>true,"message"=>"Proveedores Eliminados."));
    } else {
        echo json_encode(array("success"=>false,"message"=>"Ocuri&oacute; un Error."));
    }
?>