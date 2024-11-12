<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/solicitud_servicio.php");
include("../../modelo/solicitud_activo.php");
include("../../modelo/solicitud_material.php");

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$bd = new conexion(); 
$id_trabajador     = $_POST[id_trabajador];
$file_input        = (!empty($_FILES['cursos']['name'])) ? $_FILES['cursos'] : '';
$fecha_solicitud   = date("Y-m-d H:i:s");
$target_dir = "../../files/cursos" . DIRECTORY_SEPARATOR;
$target_file = $target_dir . $id_trabajador . "_" . "CURSOS" . "_" . $fecha_solicitud . ".pdf";
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
    if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
        $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`) VALUES ($id_trabajador, 'CURSOS', '$fecha_solicitud')");
        if($bd->numFila_afectada()>0){
            echo json_encode(array("success" => true, "message" => "Exito al guardar"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error al guardar", "message2" => "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`) VALUES ($id_trabajador, 'HOJA DE VIDA', '$fecha_solicitud')", "message3" => $id_trabajador));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Ocuri&oacute; un Error. Al subir el archivo."));
    }
}
