<?php
    session_start();
    include("../../modelo/conexion.php");
    include("../../modelo/funciones.php");
    $id   = $_GET[id];
    $bd = new conexion();
    $res = $bd->Consulta("SELECT * FROM preguntas_convocatoria WHERE id_convocatoria = $id ORDER BY id_preguntas DESC");
    $info = array();
    $information = array();
    while($response = $bd->getFila($res)){
        $information = array(
            "id" => $response[id_preguntas],
            "enunciado_preguntas" => utf8_encode($response[enunciado_preguntas]),
            "calificacion_preguntas" => $response[calificacion_preguntas],
            "id_convocatoria" => $response[id_convocatoria]
        );
        array_push($info, $information);
    }
    echo json_encode(array(
        "success" => true, 
        "info" => $info, 
        "message" => "SELECT * FROM preguntas_convocatoria WHERE id_convocatoria = $id ORDER BY id_preguntas DESC"
    ));
?>