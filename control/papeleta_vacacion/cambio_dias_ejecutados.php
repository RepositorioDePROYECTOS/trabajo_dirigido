<?php
include("../../modelo/papeleta_vacacion.php");
include("../../modelo/uso_vacacion.php");
include("../../modelo/detalle_vacacion.php");
include("../../modelo/vacacion.php");
include("../../modelo/funciones.php");

referer_permit();
date_default_timezone_set('America/La_Paz');
$fecha_registro = date("Y-m-d");
$papeleta_vacacion = new papeleta_vacacion();
$uso_vacacion = new uso_vacacion();
$detalle_vacacion = new detalle_vacacion();
$vacacion = new vacacion();
$bd = new conexion();
$id_papeleta_vacacion = security($_GET[id]);
$dias_ejecutados      = security($_GET[dias_ejecutados]);

$find_days = $bd->Consulta("SELECT * 
    FROM papeleta_vacacion pv 
    INNER JOIN detalle_vacacion dv ON pv.id_detalle_vacacion=dv.id_detalle_vacacion 
    WHERE pv.id_papeleta_vacacion= $id_papeleta_vacacion");
$find = $bd->getFila($find_days);

$change_use_hollidays = $uso_vacacion->dias_ejecutados($id_papeleta_vacacion, $dias_ejecutados);

if ($change_use_hollidays) {
    $res2 = $detalle_vacacion->update_dias($find[id_detalle_vacacion], $find[cantidad_dias], $find[dias_utilizados], $find[dias_solicitados], $dias_ejecutados);
    if ($res2) {
        $res3 = $vacacion->actualizar_vacacion_acumulada($find[id_vacacion]);
        if($result3)
        {
            echo json_encode(array(
                "success" => true,
                "message" => "Todos los registros modificados"
            ));
        }
        else
        {
            echo json_encode(array(
                "success" => false,
                "message" => "Error la modificar la vacacion acumulada.",
                "message1" => $id_papeleta_vacacion,
                "message2" => $dias_ejecutados,
                "message3" => $$find[id_detalle_vacacion],
                "message4" => $find[cantidad_dias],
                "message5" => $find[saldo_dias],
                "message6" => $find[dias_utilizados]
            ));
        }
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Error la modificar uso de vacacion.",
            "message1" => $id_papeleta_vacacion,
            "message2" => $dias_ejecutados,
            "message3" => $$find[id_detalle_vacacion],
            "message4" => $find[cantidad_dias],
            "message5" => $find[saldo_dias],
            "message6" => $find[dias_utilizados]
        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Error, ocurrio un error.",
        "message1" => $id_papeleta_vacacion,
        "message2" => $dias_ejecutados,
        "message3" => $$find[id_detalle_vacacion],
        "message4" => $find[cantidad_dias],
        "message5" => $find[saldo_dias],
        "message6" => $find[dias_utilizados]
    ));
}