<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
require_once('../reportes/cabeza_logo_papeleta.php');
require_once('../reportes/numero_a_letras.php');
include("../reportes/inicio_pagina_logo.php");
setlocale(LC_TIME, "es_ES");
$id_solicitud  = $_GET[id_solicitud];
$id_detalle    = $_GET[id_detalle];
$id_requisitos = $_GET[id_requisitos];
$tipo          = $_GET[tipo];
$observaciones = $_GET[observaciones];
$numero_de_orden ="";

$busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos as s INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
$datos = $bd->getFila($busqueda_requisitos);
if ($datos[tipo_solicitud] == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.id_detalle_material as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.id_partida, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_material as d ON d.id_detalle_material = r.id_detalle LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_material];
    // echo "ERROR AQUI MATERIAL";
} elseif ($datos[tipo_solicitud] == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.id_detalle_activo as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.id_detalle_servicio as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle  LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}
?>
<style>
    .cabecera {
        background-color: #21A9E1;
        padding: -10px;
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 20px;
    }

    .cabecera-tabla {
        background-color: #21A9E1;
        color: white;
    }

    .break {
        page-break-after: always;
    }

    * {
        font-size: 9px;
    }

    .letra_9 {
        font-size: 9px;
    }

    table {
        table-layout: fixed;
        width: 600px;
    }

    td.descripcion {
        width: 392px;
        word-wrap: break-word;
    }
</style>
<div class="cabecera">
    <h1 align="center" style="color: white;">
        FORMULARIO CM - 11
        <br>
        FORMULARIO DE RECEPCIÓN, CONFORMIDAD
        Y ASIGNACIÓN DE ACTIVOS FIJOS
        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>
<table align="center" width="690" class="tabla_reporte">
    <tr class="cabecera-tabla" align="center">
        <td width="345">Unidad Ejecutora</td>
        <td width="345">Lugar y Fecha</td>
    </tr>
    <tr>
        <td width="345" height="10"></td>
        <td width="345" align="right">Sucre, <?php echo date('d-m-Y'); ?></td>
    </tr>
</table>

<table align="center" width="620" class="tabla_reporte">
    <tr class="cabecera-tabla" align="center">
        <td width="170">RESPONSABLE O COMISIÓN DE RECEPCIÓN</td>
        <td width="150">SELLO DE RECEPCIÓN ACTIVOS FIJOS</td>
        <td width="300">ACTIVOS FIJOS</td>
    </tr>
    <tr>
        <td width="170" class="descripcion">SOLICITO LA VERIFICACION DE LA <br>CANTIDAD, ATRIBUTOS TECNICOS, <br> FISICOS, FUNCIONALES O DE <br> VOLUMEN DE LOS BIENES DE USO <br> QUE INGRESAN Y POSTERIOR <br> ENTREGA Y ACTIVACION.</td>
        <td width="150" rowspan="4" style="vertical-align: bottom;" align="center"><strong>FIRMA </strong>
        </td>
        <td width="300" rowspan="3" style="vertical-align: top;">
            <table width="100%" align="center" style="margin:0px;">
                <tr width="300">
                    <td width="320" style="vertical-align: top; font-size:7pt; word-break: break-all;" align="center">Realizar el Cotejamiento, Verificacion, Codificacion y posterior Activacion al Activo Fijo de la Entidad en el sistema SIAF.</td>
                </tr>
                <tr width="300">
                    <td width="320" height="30"></td>
                </tr>
                <tr width="300">
                    <td width="320" align="center"><strong>SELLO Y FIRMA RESPONSABLE DE ACTIVOS FIJOS</strong></td>
                </tr>
                <tr width="300">
                    <td width="320" height="30"></td>
                </tr>
                <tr width="300">
                    <td width="320" align="center"><strong>SELLO Y FIRMA AUXILIAR DE ACTIVOS FIJOS</strong></td>
                </tr>
                <tr width="300">
                    <td width="320">
                        Solicito la verificacion de criterio tecnico especializado <br>
                        <table width="300">
                            <tr>
                                <td width="110" align="left"><strong>SISTEMAS </strong> </td>
                                <td width="10" height="10"></td>
                                <td width="110" align="left"><strong>OTRO </strong> </td>
                                <td width="10" height="10"></td>
                            </tr>
                        </table>
                        <br><br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="170">
            <table style="width: 130px" class="tabla_reporte">
                <tr>
                    <td width="150">Orden de Compra</td>
                    <td width="20" height="10"></td>
                </tr>
                <tr>
                    <td width="150">Acta de Recepción</td>
                    <td width="20" height="10"></td>
                </tr>
                <tr>
                    <td width="150">Otros</td>
                    <td width="20" height="10"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="170" height="100"></td>
    </tr>
    <tr>
        <td width="170" align="center"> <strong>SELLO Y FIRMA </strong></td>
        <td width="300" align="center">
            <table width="300" border="0">
                <tr align="center">
                    <td width="150"> <strong>FIRMA TECNICO </strong></td>
                    <td width="150"> <strong>VºB º JEFE DE AREA </strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" width="600" class="tabla_reporte">

    <tr class="cabecera-tabla" align="center">
        <td rowspan="2" width="10">N°</td>
        <td rowspan="2" width="60">Cantidad</td>
        <td rowspan="2" width="60">Unidad</td>
        <td rowspan="2" width="240">Detalle</td>
        <!-- <td rowspan="2" width="150">Partida <br>Presupuestaria</td> -->
        <td colspan="2" width="120">Importe</td>
    </tr>
    <tr class="cabecera-tabla" align="center">
        <td colspan="1" width="100">Precio Unitario</td>
        <td colspan="1" width="100">Total</td>
    </tr>
    <!-- <tr align="center">
        <td width="40"></td>
        <td width="80"></td>
        <td width="80"></td>
        <td width="200"></td>
        <td width="80"></td>
        <td width="60"></td>
        <td width="60"></td>
    </tr> -->
    <?php
    $total = 0;
    while ($registro_s = $bd->getFila($datos_requisitos)) {
        $n++; 
        $cantidad = floatval($registro_s[cantidad_solicitada]) ? intval($registro_s[cantidad_solicitada]) : $registro_s[cantidad_solicitada];
        $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
        $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
        ?>
        <tr>
            <td width="10" class="letra_9" align="center"> <?php echo utf8_encode($n) ?></td>
            <td width="60" class="letra_9" align="center"> <?php echo $cantidad; ?></td>
            <td width="60" class="letra_9" align="center"> <?php echo utf8_encode($registro_s[unidad_medida]) ?></td>
            <td width="240" class="letra_9"> <strong><?php echo " " . utf8_encode($registro_s[descripcion]) ?> </strong><br>
                <?php
                if ($tipo == "material") {
                    $requisitos_detallados = $bd->Consulta("SELECT e.especificacion
                                        FROM especificaciones_material as e
                                        INNER JOIN detalle_material as d ON e.id_detalle_material = d.id_detalle_material
                                        WHERE d.id_detalle_material=$registro_s[id_detalle];");
                } elseif ($tipo == 'activo') {
                    $requisitos_detallados = $bd->Consulta("SELECT e.especificacion
                                        FROM especificaciones_activo as e
                                        INNER JOIN detalle_activo as d ON e.id_detalle_activo = d.id_detalle_activo
                                        WHERE d.id_detalle_activo=$registro_s[id_detalle];");
                } else {
                    $requisitos_detallados = $bd->Consulta("SELECT e.especificacion
                                        FROM especificaciones_servicio as e
                                        INNER JOIN detalle_servicio as d ON e.id_detalle_servicio = d.id_detalle_servicio
                                        WHERE d.id_detalle_servicio=$registro_s[id_detalle];");
                }
                echo "<ul>";
                while ($requisitos = $bd->getFila($requisitos_detallados)) {
                    echo "<li>$requisitos[especificacion]</li>";
                }
                echo "</ul>";
                ?>
            </td>
            <!-- <td width="150" class="letra_9" align="center"> <?php // echo utf8_encode($registro_s[nombre_partida]) ?></td> -->
            <td width="100" class="letra_9" align="right"> <?php echo $precio_unitario; ?></td>
            <td width="100" class="letra_9" align="right"> <?php echo $precio_total; ?></td>
        </tr>
    <?php $total = $total + $registro_s[precio_total];
    }
    ?>
    <tr>
        <td colspan="5" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($total, 2, ',', '.'); ?></td>
    </tr>
    <tr>
        <td colspan="6">
            <strong>SON <?php echo numeroALetras($total); ?></strong>
        </td>
    </tr>
    <?php if (strlen($observaciones) > 0) { ?>
        <tr class="cabecera-tabla">
            <td colspan="7" align="left">Observaciones</td>
        </tr>
        <tr>
            <td colspan="7" align="left"> <?php echo $observaciones; ?></td>
        </tr>
    <?php } ?>

    <tr class="cabecera-tabla">
        <td colspan="7" align="left">2.- CONFORMIDAD DE RECEPCIÓN</td>
    </tr>
    <tr class="cabecera-tabla">
        <td colspan="7" align="center">Conformidad de Recepción</td>
    </tr>
    <tr>
        <td colspan="7" align="justify">
            Para Contrataciones hasta Bs. 20.000.- La Unidad Solicitante se constituye en RESPONSABLE DE RECEPCIÓN, que habiendo verificado el cumplimiento de las especificaciones técnicas, de acuerdo a Contrato u Orden de Compra, procede a emitir mi CONFORMIDAD del Bien Adquirido, en constancia firmo el presente formulario.
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center"><br><br><br><br><br><br>SELLO Y FIRMA</td>
        <td colspan="3" align="center"><br><br><br><br><br><br>SELLO Y FIRMA DEL TECNICO</td>
    </tr>
    <tr>
        <td colspan="4" align="center">RESPONSABLE O COMISIÓN DE RECEPCIÓNSello</td>
        <td colspan="3" align="center">UNIDAD DE ACTIVOS FIJOSSello</td>
    </tr>
    <tr class="titulo">
        <td colspan="7" class="cabecera-tabla">3.- SOLICITUD DE ASIGNACIÓN DE BIENES, CODIFICACIÓN Y POSTERIOR ACTIVACION EN EL SIAFSI</td>
    </tr>
    <tr>
        <td colspan="7">SI CUMPLIERA CON LAS ESPECIFICACIONES TÉCNICAS, SOLICITO LA ASIGNACION DE LOS SIGUIENTES ACTIVOS FIJOS:</td>
    </tr>
    <tr class="cabecera-tabla">
        <td colspan="1" align="center">Item</td>
        <td colspan="3" align="center">CARGO Y AREA A LA QUE PERTENECE</td>
        <td colspan="3" align="center">NOMBRE Y APELLIDO DEL SERVIDOR PUBLICOUNIDAD</td>
    </tr>
    <tr>
        <td colspan="1" align="center" height="10">1</td>
        <td colspan="3" align="center" height="10"></td>
        <td colspan="3" align="center" height="10"></td>
    </tr>
    <tr>
        <td colspan="1" align="center" height="10">2</td>
        <td colspan="3" align="center" height="10"></td>
        <td colspan="3" align="center" height="10"></td>
    </tr>
    <tr>
        <td colspan="1" align="center" height="10">3</td>
        <td colspan="3" align="center" height="10"></td>
        <td colspan="3" align="center" height="10"></td>
    </tr>
    <tr>
        <td colspan="1" align="center" height="10">4</td>
        <td colspan="3" align="center" height="10"></td>
        <td colspan="3" align="center" height="10"></td>
    </tr>
    <tr>
        <td colspan="1" align="center" height="10">5</td>
        <td colspan="3" align="center" height="10"></td>
        <td colspan="3" align="center" height="10"></td>
    </tr>

</table>
<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Recepcion_Solicitud_".$id_solicitud."_Tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>