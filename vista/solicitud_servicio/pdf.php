<?php
session_start();

require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();

require_once('../reportes/cabeza_logo_papeleta.php');
require_once('../reportes/numero_a_letras.php');
include("../reportes/inicio_pagina_logo.php");


setlocale(LC_TIME, "es_ES");
$id_solicitud_servicio  = $_GET[id];
// $id_solicitud_servicio  = $_SESSION[id];

$registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio=$id_solicitud_servicio");
$registro = $bd->getFila($registros_solicitud);
$numero_de_orden = $registro[nro_solicitud_servicio];

$registros_s = $bd->Consulta("SELECT d.*,p.nombre_partida from detalle_servicio as d LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE d.id_solicitud_servicio=$id_solicitud_servicio");

?>
<style>
    .cabecera {
        background-color: #21A9E1;
        padding: -10px;
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 20px;
    }


    .cabecera2 {
        position: absolute;
        background-color: #21A9E1;
        padding: 5px;
        margin-left: -5px;
        margin-right: -5px;
        margin-bottom: 10px;
        font-size: 20px;
        color: white;
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

    td,
    th {
        max-width: 50px;
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que desborda */
        text-overflow: ellipsis;
        /* Muestra puntos suspensivos (...) cuando se corta el contenido */
    }

    td.descripcion {
        width: 260px;
        word-wrap: break-word;

    }
    td.descripcion2 {
        /* width: 260px; */
        white-space: nowrap;
        word-wrap: break-word;
        /* margin-right: 150px  */
    }

    .salto-texto {
        word-break: break-all;
    }

    .miCelda {
        /* width: 220px; */
    }
</style>
<!-- Inicio de la Solicitud -->
<div class="cabecera">
    <h1 align="center" style="color:white;">
        FORMULARIO CM - 02
        <br>
        SOLICITUD DE INICIO DE CONTRATACIÓN MENOR
        <br>
        SERVICIO   Nro. <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>
<p align="center">(DE Bs1.- HASTA Bs50.000.-)</p>

<table align="center" width="670" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td colspan="4" align="center" class="cabecera-tabla"><strong>PAPELETA SOLICITUD DE servicio</strong></td>
    </tr>
    <tr>
        <td width="190" class="cabecera-tabla"><strong>ITEM:</strong></td>
        <td width="230"><?php echo $registro[item_solicitante]; ?></td>
        <td width="160" class="cabecera-tabla"><strong>FECHA SOLICITUD:</strong></td>
        <td width="90"><?php echo date("d-m-Y", strtotime($registro[fecha_solicitud])); ?></td>
    </tr>
    <tr>
        <td width="120" class="cabecera-tabla"><strong>UNIDAD SOLICITANTE:</strong></td>
        <td width="230" colspan="3"><?php echo ($registro[unidad_solicitante] != NULL) ? strtoupper(utf8_encode($registro[unidad_solicitante])) : strtoupper($registro[oficina_solicitante]); ?></td>
    </tr>
    <tr>
        <td width="120" class="cabecera-tabla"><strong>OBJETO CONTRATACION:</strong></td>
        <td width="230" colspan="3"><?php echo strtoupper(utf8_encode($registro[objetivo_contratacion])); ?></td>
    </tr>
    <tr>
        <td width="120" class="cabecera-tabla"><strong>JUSTIFICATIVO:</strong></td>
        <td width="480" colspan="3"><?php echo strtoupper(utf8_encode($registro[justificativo])); ?></td>
    </tr>
</table>
<table align="center" width="640" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td colspan="6" align="left"><strong>Mediante la presente realizo la siguiente descripcion de los Bienes y/o Servicios a contratar:</strong></td>
    </tr>
    <tr>
        <td width="10" align="center"><strong class="letra_9">Nro</strong></td>
        <td width="65" align="center"><strong class="letra_9">Cantidad</strong></td>
        <td width="70" align="center"><strong class="letra_9">Unidad Medida</strong></td>
        <td width="355" align="center"><strong class="letra_9">Descripción</strong></td>
        <!-- <td align="center"><strong class="letra_9">Partida Presupuestaria</strong></td> -->
        <td width="70" align="center"><strong class="letra_9">Precio Unitario</strong></td>
        <td width="70" align="center"><strong class="letra_9">Subtotal</strong></td>
    </tr>
    <?php
    $total = 0;
    while ($registro_s = $bd->getFila($registros_s)) {
        $n++;
        $subtotal = $registro_s[precio_total];
        echo "<tr>";
        echo strtoupper(utf8_encode(
            "
                    <td width='10' class='letra_9' align='center'>$n</td>
                    <td width='65' class='letra_9' align='center'>$registro_s[cantidad_solicitada]</td>
                    <td width='70' class='letra_9'>$registro_s[unidad_medida]</td>
                    <td width='350' class='letra_9 descripcion'>$registro_s[descripcion]</td>
                    
                    <td width='70' class='letra_9' align='right'>$registro_s[precio_unitario]</td>
                    <td width='70' class='letra_9' align='right'>".number_format($subtotal, 2, ',', '.')."</td>"
        ));
        // <td class='letra_9 salto-texto' width='190' align='center'>$registro_s[nombre_partida]</td>
        echo "</tr>";
        $total = $total + $subtotal;
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
</table>

<table width="600" align="center" border="0">
    <tr>
        <!-- Principal -->
        <td width="180" height="100" align="center" style="border: 2px solid black;">
            <br><br><br><br><br><br><br>
            <strong>Fecha:__/__/____</strong>
            <br><br>
            <strong>CERTIFICACION SIN EXISTENCIAS <br> SELLO Y FIRMA RESPONSABLE DE <br> ALMACENES/ACTIVOS FIJOSSELLO</strong>
        </td>
        <!-- Principal -->
        <td width="130" height="80" align="center">
            <br><br><br><br><br><br>
            <?php echo strtoupper(utf8_encode($registro[nombre_solicitante])); ?>
            <br>
            <strong>FIRMA SOLICITANTE</strong>
        </td>
        <td width="130" height="80" align="center">
            <br><br><br><br><br><br>
            <?php echo utf8_encode($registro[unidad_solicitante]); ?>
            <br>
            <strong>JEFE UNIDAD SOLICITANTE</strong>
        </td>
        <td width="130" height="80" align="center">
            <br><br><br><br><br><br>
            <?php echo utf8_encode($registro[gerente_area]); ?>
            <br>
            <strong>GERENTE DE AREA</strong>
        </td>
    </tr>
    <tr>
        <td width="180" height="100" align="center" style="border: 2px solid black;">
            <br><br><br><br><br><br><br>
            <strong>Fecha:__/__/____</strong>
            <br><br>
            <strong>FIRMA RESPONSABLE DE <br> PRESUPUESTOS</strong>
        </td>
        <td width="130" height="80" align="center">

        </td>
        <td width="130" height="80" align="center">

        </td>
        <td width="130" height="80" align="center">

        </td>
    </tr>
    <tr class="cabecera-tabla">
        <td colspan="4">CONTROL DE DOCUMENTOS POR EL RPA Y AUTORIZACIÓN DEL INICIO DE PROCESOTOTAL:</td>
    </tr>
    <tr>
        <td width="150" height="100" align="left">
            <table width="200" height="100" align="left" style="border-collapse: collapse;" border="2">
                <tr height="33.33">
                    <td style="font-size: 5pt;">CERTIFICACIÓN PRESUPUESTARIA</td>
                    <td height="33.33" width="10px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-size: 5pt;">INSCRITO EN EL POA</td>
                    <td height="33.33" width="10px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-size: 5pt;">INSCRITO EN EL PAC(PARA MONTOS MAYORES A BS.-20,000)</td>
                    <td height="33.33" width="10px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="100" colspan="2" height="100" align="center">

        </td>
        <td width="150">
            <table width="150" border="2" style="border-collapse: collapse;">
                <tr>
                    <td colspan="2" height="90" style="font-size: 5pt; vertical-align: top;">AUTORIZO EL INICIO DE PROCESO DE CONTRATACIÓN MENOR</td>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <strong>SELLO Y FIRMA RPA</strong>
                    </td>
                </tr>
                <tr>
                    <td>FECHA</td>
                    <td align="center"> </td>
                </tr>
            </table>
            <!-- <strong>Fecha:__/__/____</strong>
                <br><br>
                <strong>INICIO ADQUISICION <br>RPA</strong> -->
        </td>
    </tr>
</table>
<div class="break">
</div>
<!-- Cerrado forsoso de la pagina para iniciar la nueva hoja -->
</page>
<page backtop="25mm" backbottom="14mm" backleft="0mm" backright="0mm" backimg="" style="font-size: 10pt">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 30%; text-align: left;">
                    <img src="../reportes/images/logo.png" />
                </td>
                <td style="width: 30%; text-align: center">
                    &nbsp;
                </td>
                <td style="width: 40%; text-align: center;">
                    <?php
                    echo $entidad->nombre_entidad . "<br>";
                    echo $entidad->direccion . "<br>";
                    echo $entidad->telefonos . "<br>";
                    echo $entidad->correo;
                    ?>
                </td>
            </tr>
        </table>

    </page_header>
    <?php
    $especificaciones_tecnicas = $bd->Consulta("SELECT s.unidad_solicitante, s.objetivo_contratacion,s.oficina_solicitante, s.nombre_solicitante, dm.descripcion, dm.id_detalle_servicio 
        FROM solicitud_servicio as s 
        INNER JOIN detalle_servicio as dm ON dm.id_solicitud_servicio = s.id_solicitud_servicio 
        WHERE s.id_solicitud_servicio=$id_solicitud_servicio");
    $especificacion = $bd->getFila($especificaciones_tecnicas);
    ?>
    <table align="center" width="600" class="cabecera2">
        <tr>
            <td colspan="2" width="600" align="center">FORMULARIO CM - 01 ESPECIFICACIONES TECNICAS</td>
        </tr>
        <tr>
            <td width="200" align="left"><strong>UNIDAD SOLICITANTE:</strong></td>
            <td width="400" align="right"><?php echo strtoupper(utf8_encode($especificacion[oficina_solicitante])); ?></td>
        </tr>
        <tr>
            <td width="200" align="left"><strong>OBJETIVO DE CONTRATACION:</strong></td>
            <td width="400" align="right"><?php echo strtoupper(utf8_encode($especificacion[objetivo_contratacion])) ?></td>
        </tr>
        <tr>
            <td width="200" align="left"><strong>RESPONSABLE DE ELABORACION:</strong></td>
            <td width="400" align="right" colspan="3"><?php echo strtoupper(utf8_encode($especificacion[nombre_solicitante])); ?></td>
        </tr>
    </table>
    <br>
    <!-- iteracion de los datos -->
    <?php
    $iteracion_especificaciones_tecnicas = $bd->Consulta("SELECT ds.descripcion, ds.id_detalle_servicio 
        FROM solicitud_servicio as s 
        INNER JOIN detalle_servicio as ds ON ds.id_solicitud_servicio = s.id_solicitud_servicio 
        WHERE s.id_solicitud_servicio=$id_solicitud_servicio");
    // $consulta_principal = "SELECT dm.descripcion, dm.id_detalle_servicio 
    // FROM solicitud_servicio as s 
    // INNER JOIN detalle_servicio as dm ON dm.id_solicitud_servicio = s.id_solicitud_servicio 
    // WHERE s.id_solicitud_servicio=$id_solicitud_servicio";
    // echo $consulta_principal;
    while ($datos_iteracion = $bd->getFila($iteracion_especificaciones_tecnicas)) {
    ?>

        <table align="center" width="600" class="tabla_reporte">
            <tr>
                <td width="150" class="cabecera-tabla"><strong>DATOS GENERALES DEL REQUERIMIENTO:</strong></td>
                <td width="450" class="cabecera-tabla"><?php echo strtoupper($datos_iteracion[descripcion]); ?></td>
            </tr>
        </table>
        <table align='center' width="580" class='tabla_reporte'>
            <tr class="cabecera-tabla" align="center">
                <td width="150"><strong>Nro</strong></td>
                <td width="450"><strong>TECNICASDESCRIPCION DEL BIEN/SERVICIO</strong></td>
            </tr>
            <?php
            $datos_iteracion_especificaciones = $bd->Consulta("SELECT * FROM especificaciones_servicio WHERE id_detalle_servicio=$datos_iteracion[id_detalle_servicio]");
            $index = 1;
            while ($tecnicismos = $bd->getFila($datos_iteracion_especificaciones)) {
            ?>

                <tr>
                    <td width="150" align="center"><?php echo $index; ?></td>
                    <td width="430" class='descripcion2'>
                        <div><?php echo strtoupper(utf8_encode($tecnicismos[especificacion])); ?></div>
                    </td>
                </tr>
                <?php $index++; ?>
            <?php
            }
            ?>
        </table>
        <?php
            $buscar_datos = $bd->Consulta("SELECT ds.descripcion, ds.id_detalle_servicio 
            FROM solicitud_servicio as s 
            INNER JOIN detalle_servicio as ds ON ds.id_solicitud_servicio = s.id_solicitud_servicio
            INNER JOIN especificaciones_servicio as es ON es.id_detalle_servicio = ds.id_detalle_servicio
            WHERE es.id_detalle_servicio=$datos_iteracion[id_detalle_servicio]");
            $buscar_dato = $bd->getFila($buscar_datos);
            if(!$buscar_dato){
                echo "<br>";
            }
        ?>
    <?php
    }
    ?>
    <table border="0" width="700">
        <tr>
            <td width="350" height="80" align="center"><br><br><br><br><br><br>__________________________________<br><strong>SELLO Y FIRMA <br>RESPONSABLE ELABORACION DEL FORMULARIO</strong></td>
        </tr>
    </table>
    <page_footer>
        <table class="page_footer">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 33%; text-align: left;">
                </td>
                <td style="width: 34%; text-align: center">
                    p&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 33%; text-align: right">
                    Fecha Impresi&oacute;n <?php echo date('d/m/Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <?php
    echo "</page>";
    $content = ob_get_clean();

    try {
        $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('papeleta_solicitud_servicio.pdf');
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id]);
    ?>