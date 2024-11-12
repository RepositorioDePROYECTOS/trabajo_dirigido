<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/solicitud_servicio.php");
include("../../modelo/solicitud_activo.php");
include("../../modelo/solicitud_material.php");

// referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$bd = new conexion();
$id_trabajador        = $_POST[id_trabajador_registro];
$tipo_registro        = utf8_decode($_POST[tipo_registro]);
$file_input           = (!empty($_FILES['file']['name'])) ? $_FILES['file'] : '';
$fecha_solicitud      = date("Y-m-d H:i:s");
$fecha_solicitudd      = date("Y-m-d H:i:s");
$fecha_solicitudd      = str_replace(' ', '_', $fecha_solicitudd); // Reemplazar espacios con "_"
$fecha_solicitudd      = str_replace(':', '-', $fecha_solicitudd); // Reemplazar dos puntos con "_"
$detalle_dp           = utf8_decode($_POST[detalleDP]);
$detalle_sap          = utf8_decode($_POST[detalleSAP]);
$detalle_contratos    = utf8_decode($_POST[detalleContratos]);
$detalle_afiliaciones = utf8_decode($_POST[detalleAfiliaciones]);
$fecha_inicio_m       = utf8_decode($_POST[fechaInicioMemorandun]);
$fecha_fin_m          = utf8_decode($_POST[fechaFinMemorandun]);
$fecha_inicio_c       = utf8_decode($_POST[fechaInicioComunicacionInterna]);
$fecha_fin_c          = utf8_decode($_POST[fechaFinComunicacionInterna]);
$tipo_trabajador = "ITEM";
$tipo = "";

// echo json_encode(array("success" => false, "message" => $id_trabajador. " tipo: " . $tipo_registro . " file: " . $file_input));
if ($tipo_registro == 'hoja_vida') {
    $tipo = "HOJA DE VIDA";
    $target_dir = "../../files/hoja_vida" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'documentos_personales') {
    $tipo = "DOCUMENTOS PERSONALES";
    $target_dir = "../../files/documentos_personales" . DIRECTORY_SEPARATOR;
    $target_dir = "../../files/documentos_personales" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_dp', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_dp', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'cursos') {
    $tipo = "CURSOS";
    $target_dir = "../../files/cursos" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'experiencia') {
    $tipo = "EXPERIENCIA LABORAL";
    $target_dir = "../../files/experiencia_laboral" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'memorandun') {
    $tipo = "MEMORANDUN";
    $target_dir = "../../files/memorandun" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$fecha_inicio_m', '$fecha_fin_m', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$fecha_inicio_m', '$fecha_fin_m')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'comunicacion_interna') {
    $tipo = "COMUNICACION INTERNA";
    $target_dir = "../../files/comunicacion_interna" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$fecha_inicio_c', '$fecha_fin_c', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar."  . "INSERT INTO `files`(`id_trabajador`, `tipo`, `fecha_creacion`, `fecha_inicio`, `fecha_fin`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$fecha_solicitud', '$fecha_inicio_c', '$fecha_fin_c')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'otros_documentos') {
    $tipo = "OTROS DOCUMENTOS";
    $target_dir = "../../files/otros_documentos" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_sap', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar."  . "INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_sap', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'contratos') {
    $tipo = "CONTRATOS";
    $target_dir = "../../files/contratos" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_contratos', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_contratos', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} elseif ($tipo_registro == 'afiliaciones') {
    $tipo = "AFILIACIONES";
    $target_dir = "../../files/afiliaciones" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . $id_trabajador . "_" . str_replace(' ', '_', $tipo) . "_" . $fecha_solicitudd . ".pdf";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_input["size"] > 5000000) {
        echo "Ocuri&oacute; un Error. Archio demasiado grande.";
        $uploadOk = 0;
    }
    if ($fileType != "pdf") {
        echo "Ocuri&oacute; un Error. EL archivo no es PDF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Ocuri&oacute; un Error al guardar.";
    } else {
        if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
            $consulta = $bd->Consulta("INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_afiliaciones', '$fecha_solicitud', '$tipo_trabajador')");
            if ($bd->numFila_afectada() > 0) {
                echo "Datos registrados.";
            } else {
                echo "Ocuri&oacute; un Error al guardar." . "INSERT INTO `files`(`id_trabajador`, `tipo`, `detalle`, `fecha_creacion`, `tipo_trabajador`) VALUES ($id_trabajador, '$tipo', '$detalle_afiliaciones', '$fecha_solicitud')";
            }
        } else {
            echo "Ocuri&oacute; un Error al subir el archivo.";
        }
    }
} else {
    echo "Ocuri&oacute; un Error, en la categoria seleccionada";
}
