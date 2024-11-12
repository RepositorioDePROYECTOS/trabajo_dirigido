<?php
include("../../modelo/detalle_vacacion.php");
include("../../modelo/vacacion.php");
include("../../modelo/funciones.php");

referer_permit();
$bd = new conexion();

$obtener_trabajador = $bd->Consulta("SELECT id_trabajador, nombres, apellido_paterno, apellido_materno FROM trabajador WHERE estado_trabajador = 'HABILITADO'");
while ($iteracion1 = $bd->getFila($obtener_trabajador)) {
    // echo $iteracion1[id_trabajador] . " - " . $iteracion1[nombres] . " " . $iteracion1[apellido_paterno] . "<br>";
    $obtener_vacacion = $bd->Consulta("SELECT id_vacacion FROM vacacion WHERE id_trabajador = $iteracion1[id_trabajador]");
    while($iteracion2 = $bd->getFila($obtener_vacacion)) {
        $obtener_detalle_vacacion = $bd->Consulta("SELECT id_detalle_vacacion, cantidad_dias FROM detalle_vacacion WHERE id_vacacion = $iteracion2[id_vacacion]");
        // $contenedor_cantidad_dias = 0;
        while($iteracion3 = $bd->getFila($obtener_detalle_vacacion)) {
            $obtener_papeleta_vacacion = $bd->Consulta("SELECT dias_solicitados FROM papeleta_vacacion WHERE id_detalle_vacacion = $iteracion3[id_detalle_vacacion] ORDER BY id_papeleta_vacacion ASC");
            $contenedor_cantidad_dias = $iteracion3[cantidad_dias];
            while($iteracion4 = $bd->getFila($obtener_papeleta_vacacion)) {
                echo $iteracion1[id_trabajador] . " - " . $iteracion1[nombres] . " " . $iteracion1[apellido_paterno] . " Vacacion: " . $iteracion2[id_vacacion] . " D. Vacacion " . $iteracion3[id_detalle_vacacion] . " Dias obtenidos " . $iteracion3[cantidad_dias] . " Dias Solicitados " . $iteracion4[dias_solicitados] .  " Saldo Dias: " . $contenedor_cantidad_dias ."<br>";
                // $modificar_datos_papeleta_vacacion = $bd->Consulta("UPDATE papeleta_vacacion SET saldo_dias = '$contenedor_cantidad_dias' WHERE id_detalle_vacacion = $data2[id_papeleta_vacacion]");
                // $modificar_papeleta_vacacion = $bd->getFila($modificar_datos_papeleta_vacacion);
                $contenedor_cantidad_dias = $contenedor_cantidad_dias - $iteracion4[dias_solicitados];
            }
        }
    }
}


if ($bd->numFila_afectada() > 0)
    return true;
else
    return false;
