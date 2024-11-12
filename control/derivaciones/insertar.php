<?php 
    include('../../modelo/derivaciones.php');
    include("../../modelo/funciones.php");

    referer_permit();
    // date_default_timezone_set('America/La_Paz');
    setlocale(LC_TIME,"es_ES");
    ini_set('date.timezone','America/La_Paz');
    // $id_derivacion     = $_GET[id];
    $id_solicitud      = intval($_POST[id]);
    $id_trabajador     = intval($_POST[id_trabajador]);
    $tipo_solicitud    = utf8_decode($_POST[tipo_solicitud]); 
    $id_usuario        = intval($_POST[id_usuario]);
    $nro_solicitud     = intval($_POST[nro_solicitud]);
    $tipo_trabajador   = $_POST[tipo_trabajador];
    $fecha_derivado    = date('Y-m-d');
    $fecha_respuesta   = date('Y-m-d H:i:s');
    $estado_derivacion = 'solicitado';
    // echo "ID_S :".$id_solicitud."<br>".
    // "ID_T :".$id_trabajador."<br>".
    // "TIPO :".$tipo_solicitud."<br>".
    // "FECHA :".$fecha_derivacion."<br>".
    // "ESTADO :".$estado_derivacion;
    if(empty($id_trabajador)){
        echo json_encode(array("false" => true, "message" => "Error, no se selecciono a quien derivar!"));
    }

    $derivacion = new derivaciones();
    $bd = new conexion(); 
    // Diferencia Trabajadores
    if($tipo_trabajador == 'ITEM') {
        $usuario = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador WHERE u.id_usuario=$id_usuario");
        $user = $bd->getFila($usuario);
    } else {
        $usuario = $bd->Consulta("SELECT t.id_eventual as id_trabajador FROM eventual as t INNER JOIN usuario as u ON u.id_eventual = t.id_eventual WHERE u.id_usuario=$id_usuario");
        $user = $bd->getFila($usuario);
    }
    // Diferencia Trabajadores
    $ultimo = $bd->Consulta("SELECT id_derivacion  FROM derivaciones ORDER BY id_derivacion  DESC LIMIT 1");
    $u = $bd->getFila($ultimo);
    if($u[id_derivacion] == 0 || $u[id_derivacion] == NULL){
        $id = 1;
    } else {
        $id = intval($u[id_derivacion]) + 1;
    }
    // echo json_encode(array("success" => false, "message" => "ID_SOL: ".$id_solicitud." ID_TRAB: ".$id_trabajador." TIPO SOL: ".$tipo_solicitud." FECHA D: ".$fecha_derivado." FECHA R: ".$fecha_respuesta." ESTADO: ".$estado_derivacion));
    

    $result = $derivacion->registrar_derivacion($id_solicitud, $nro_solicitud, $id_trabajador, $tipo_solicitud, $fecha_derivado, $fecha_respuesta, $estado_derivacion, $tipo_trabajador);
    $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($id, $id_solicitud, $user[id_trabajador], '$tipo_solicitud', '$tipo_trabajador', '$estado_derivacion')");
    // echo "Datos registrados.";
    if($historico){

        echo json_encode(array("success" => true, "message" => "Exito al derivar la Solicitud"));
    } else {
        // echo json_encode(array("success" => false, "message" => "INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($id, $id_solicitud, $id_trabajador, '$tipo_solicitud', '$estado_derivacion')"));
        echo json_encode(array("success" => false, "message" => "Error al registrar"));
    }
    if($result){
        // $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud) VALUES ('$id', $id_solicitud, $id_trabajador, '$tipo_solicitud', '$fecha_derivacion')");
    } else {
        // echo "Ocurri&oacute; un Error.";
        echo json_encode(array("success" => false, "message" => "Error al derivar"));
        // echo "INSERT into derivaciones (id_solicitud, id_trabajador, tipo_solicitud, fecha_derivacion, estado_derivacion) values ($id_solicitud, $id_trabajador, '$tipo_solicitud', '$fecha_derivacion', '$estado_derivacion')";
    }
?>