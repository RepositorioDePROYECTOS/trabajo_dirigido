<?php
    include("../../modelo/papeleta_vacacion.php");
    include("../../modelo/uso_vacacion.php");
    include("../../modelo/detalle_vacacion.php");
    include("../../modelo/vacacion.php");
    include("../../modelo/funciones.php");
    // session_start();
    referer_permit();
    date_default_timezone_set('America/La_Paz');
    $bd = new conexion();
    $fecha_registro = date("Y-m-d");
    $id_papeleta_vacacion = security($_GET[id]);
    $result = $bd->Consulta("SELECT t.nombres, t.apellido_paterno, t.apellido_materno, p.dias_solicitados
        FROM papeleta_vacacion p 
        INNER JOIN detalle_vacacion d ON d.id_detalle_vacacion  = p.id_detalle_vacacion 
        INNER JOIN vacacion v ON v.id_vacacion = d.id_vacacion 
        INNER JOIN trabajador t ON t.id_trabajador  = v.id_trabajador 
        WHERE p.id_papeleta_vacacion = $id_papeleta_vacacion");
    $res = $bd->getFila($result);
    $vacio = array();
    if($res){
        echo json_encode(array("message"=>"Encontrado", "success"=>true, "data"=>$res));
    } else {
        echo json_encode(array("message"=>"No Encontrado", "success"=>false, "data"=>$vacio));
    }
?>