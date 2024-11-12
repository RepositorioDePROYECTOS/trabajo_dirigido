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

$id_solicitud      = $_POST[id_solicitud];
$id_verificacion   = $_POST[id_verificacion];
$tipo_verificacion = $_POST[tipo_verificacion];
$fecha             = date('Y-m-d H:i:s');;
$id_usuario        = $_POST[id_usuario];
$file_input        = (!empty($_FILES['file_input']['name'])) ? $_FILES['file_input'] : '';
$fecha_solicitud   = date("Y-m-d");
$inexistencia      = ($_POST[inexistencia] != NULL) ? utf8_decode($_POST[inexistencia]) : '';

$bd = new conexion();
$tipo_trabajador = "";
// Verificacion
$verificacion_usuario = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador WHERE u.id_usuario=$id_usuario");
$verificacion_usuarios = $bd->getFila($verificacion_usuario);
if($verificacion_usuarios[id_trabajador]){
    $tipo_trabajador = "ITEM";
} else {
    // $usuario = $bd->Consulta("SELECT t.id_eventual as id_trabajador FROM eventual as t INNER JOIN usuario as u ON u.id_eventual = t.id_eventual WHERE u.id_usuario=$id_usuario");
    // $user = $bd->getFila($usuario);
    $tipo_trabajador = "EVENTUAL";
}
$trabajador = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
$t = $bd->getFila($trabajador);
$id_t = $t[id_trabajador];


if (empty($_FILES['file_input']['name'])) {
    // echo "CON COMENTARIO";
    $result = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='verificado', fecha_respuesta='$fecha', observaciones='$inexistencia' WHERE id_derivacion=$id_verificacion");
    if ($result) {

        $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($id_verificacion, $id_solicitud, $id_t, '$tipo_verificacion', '$tipo_trabajador', 'verificado')");
        if ($tipo_verificacion == "servicio") {
            // Autorizacion de la solicitud de servicio
            $solicitud_servicio = new solicitud_servicio();
            $estado_cambiado = $solicitud_servicio->verificar($id_solicitud);
        }
        if ($tipo_verificacion == "activo") {
            // Autorizacion de la solicitud de activo
            $solicitud_activo = new solicitud_activo();
            $estado_cambiado = $solicitud_activo->verificar($id_solicitud);
        }
        if ($tipo_verificacion == "material") {
            // Autorizacion de la solicitud de material
            $solicitud_material = new solicitud_material();
            $estado_cambiado = $solicitud_material->verificar($id_solicitud);
        }
        echo json_encode(array("success" => true, "message" => "Exito, Verificacion registrados."));
    } else {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. Al procesar la solicitud."));
    }
} else {
    // echo "ID Sol: ".$id_solicitud." ID Ver: ".$id_verificacion." Tipo: ".$tipo_verificacion. " FECHA: ".$fecha;
    // $target_dir = "../../documents" . DIRECTORY_SEPARATOR;
    $target_dir = "../../documents" . DIRECTORY_SEPARATOR;
    // $timestamp = time();
    $target_file = $target_dir . $id_solicitud . "_" . $tipo_verificacion . ".pdf";
    // $target_file = getcwd().DIRECTORY_SEPARATOR . $id_solicitud . "_" . $tipo_verificacion . ".pdf";
    // echo json_encode(array("success"=>false,"message"=>"target_dir".$target_dir."<br> target_file ".$target_file."<br>antiguo target: ".$target_dir. $id_solicitud . "_" . $tipo_verificacion . ".pdf"));
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Verificar si el archivo es demasiado grande
    if ($file_input["size"] > 5000000) {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. El archivo es demasiado grande."));
        $uploadOk = 0;
    }
    // Permitir solo archivos PDF
    if ($fileType != "pdf") {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. Solo se permiten archivos PDF."));
        $uploadOk = 0;
    }
    // Verificar si se produjo un error
    if ($uploadOk == 0) {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. El archivo no se pudo subir."));
        // Si todo está bien, intenta subir el archivo
    } else {
        $detalle_inexistencia = $inexistencia."_".$target_file;
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($id_verificacion, $id_solicitud, $id_t, '$tipo_verificacion', '$tipo_trabajador', 'verificado')");
            $result = $bd->Consulta("UPDATE derivaciones SET estado_derivacion='verificado', fecha_respuesta='$fecha', observaciones='$detalle_inexistencia' WHERE id_derivacion=$id_verificacion");
            if ($result) {
                $cambios_solicitudes = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion=$id_verificacion");
                $cambios_solicitud = $bd->getFila($cambios_solicitudes);
                if ($cambios_solicitud[tipo_solicitud] == "servicio") {
                    // Autorizacion de la solicitud de servicio
                    $solicitud_servicio = new solicitud_servicio();
                    $estado_cambiado = $solicitud_servicio->verificar($cambios_solicitud[id_solicitud]);
                }
                if ($cambios_solicitud[tipo_solicitud] == "activo") {
                    // Autorizacion de la solicitud de activo
                    $solicitud_activo = new solicitud_activo();
                    $estado_cambiado = $solicitud_activo->verificar($cambios_solicitud[id_solicitud]);
                }
                if ($cambios_solicitud[tipo_solicitud] == "material") {
                    // Autorizacion de la solicitud de material
                    $solicitud_material = new solicitud_material();
                    $estado_cambiado = $solicitud_material->verificar($cambios_solicitud[id_solicitud]);
                }
                // echo "Exito, Datos registrados.";
                echo json_encode(array("success" => true, "message" => "Exito al guardar"));
            } else {
                echo json_encode(array("success" => false, "message" => "Ocurri&oacute; un Error."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. Al subir el archivo."));
        }
    }
}
