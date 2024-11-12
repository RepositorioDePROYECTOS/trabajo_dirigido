<?php
session_start();

require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();

require_once('../reportes/cabeza_logo_papeleta.php');
require_once('../reportes/numero_a_letras.php');
include("../reportes/inicio_pagina_logo.php");


setlocale(LC_TIME, "es_ES");
//$id_solicitud  = $_SESSION[id];
$id_solicitud  = $_GET[id_sol];
$tipo          = $_GET[tipo];
if ($tipo == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT *, existencia_material as existencia FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.id_partida, d.precio_unitario, d.precio_total, p.nombre_partida
        FROM detalle_material as d LEFT JOIN partidas as p ON p.id_partida = d.id_partida 
        WHERE d.id_solicitud_material =$id_solicitud");
    $numero_de_orden = $registro_sol[nro_solicitud_material];
    // echo "ERROR AQUI MATERIAL";
} elseif ($tipo == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT *, existencia_activo as existencia FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida 
        FROM detalle_activo as d LEFT JOIN partidas as p ON p.id_partida = d.id_partida
        WHERE d.id_solicitud_activo =$id_solicitud");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total, p.nombre_partida 
        FROM detalle_servicio as d LEFT JOIN partidas as p ON p.id_partida = d.id_partida
        WHERE d.id_solicitud_servicio =$id_solicitud");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}

$registros_s = $bd->Consulta("select * from detalle_material where id_solicitud_material=$id_solicitud");

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
        width: 260px;
        word-wrap: break-word;
    }

    .salto-texto {
        word-break: break-all;
    }
</style>
<div class="cabecera">
    <h1 align="center" style="color:white;">
        FORMULARIO CM - 02 <br>
        SOLICITUD DE INICIO DE CONTRATACIÓN MENOR
        <!-- <br>DE <?php if ($tipo == 'servicio') {
                        // echo "SERVICIO";
                    } else {
                        // echo "COMPRA";
                    } ?> -->
        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>

<table align="center" width="670" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td colspan="4" align="center"><strong>PAPELETA SOLICITUD</strong></td>
    </tr>
    <tr>
        <td width="190"><strong>ITEM:</strong></td>
        <td width="230"><?php echo $registro_sol[item_solicitante]; ?></td>
        <td width="160"><strong>FECHA SOLICITUD:</strong></td>
        <td width="90"><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></td>
    </tr>
    <tr>
        <td width="120"><strong>UNIDAD SOLICITANTE:</strong></td>
        <td width="230" colspan="3"><?php echo ($registro_sol[unidad_solicitante] != NULL) ? strtoupper(utf8_encode($registro_sol[unidad_solicitante])) : strtoupper(utf8_encode($registro_sol[oficina_solicitante])); ?></td>
    </tr>
    <tr>
        <td width="120"><strong>OBJETO CONTRATACION:</strong></td>
        <td width="230" colspan="3"><?php echo strtoupper(utf8_encode($registro_sol[objetivo_contratacion])); ?></td>
    </tr>
    <tr>
        <td width="120"><strong>JUSTIFICATIVO:</strong></td>
        <td width="480" colspan="3"><?php echo strtoupper(utf8_encode($registro_sol[justificativo])); ?></td>
    </tr>
</table>
<table align="center" width="100%" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td colspan="7" align="left"><strong>Mediante la presente realizo la siguiente descripcion de los Bienes y/o Servicios a contratar:</strong></td>
    </tr>
    <tr>
        <td align="center"><strong class="letra_9">Nro</strong></td>
        <td align="center"><strong class="letra_9">Cantidad</strong></td>
        <td align="center"><strong class="letra_9">Unidad Medida</strong></td>
        <td align="center"><strong class="letra_9">Descripción</strong></td>
        <td align="center"><strong class="letra_9">Partida Presupuestaria</strong></td>
        <td align="center"><strong class="letra_9">Precio Unitario</strong></td>
        <td align="center"><strong class="letra_9">Subtotal</strong></td>
    </tr>
    <?php
    $total = 0;
    $precio_unitario = 0.0;
    while ($registro_s = $bd->getFila($datos_requisitos)) {
        $n++;
        $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
        $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
        $cantidad = floatval($registro_s[cantidad_solicitada]) ? intval($registro_s[cantidad_solicitada]) : $registro_s[cantidad_solicitada];
        // $subtotal = $registro_s[cantidad_solicitada] * $registro_s[precio_unitario];
        echo "<tr>";
        echo strtoupper(utf8_encode(
            "
                <td class='letra_9' align='center'>$n</td>
                <td class='letra_9' align='center'>$cantidad</td>
                <td class='letra_9'>$registro_s[unidad_medida]</td>
                <td class='letra_9 descripcion'>$registro_s[descripcion]</td>
                <td class='letra_9 salto-texto' width='190' align='center'>$registro_s[nombre_partida]</td>
                <td class='letra_9' align='right'>$precio_unitario</td>
                <td class='letra_9' align='right'>$precio_total</td>
            "
        ));
        echo "</tr>";
        $total = $total + $registro_s[precio_total];
    }
    ?>
    <tr>
        <td colspan="6" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($total, 2, ',', '.'); ?></td>
    </tr>
    <tr>
        <td colspan="7">
            <strong>SON <?php echo numeroALetras($total); ?></strong>
        </td>
    </tr>
</table>
<?php
// if ($tipo == "servicio") { 
?>
<!-- <table width="600" align="center" border="0">
        <tr>
            <td width="180" height="100" align="center" style="border: 2px solid black;">
                <br><br><br><br><br><br><br>
                <strong>Fecha:__/__/____</strong>
                <br><br>
                <strong>CERTIFICACION SIN EXISTENCIAS <br> SELLO Y FIRMA RESPONSABLE DE <br> ALMACENES/ACTIVOS FIJOSSELLO</strong>
            </td>
            <td width="130" height="80" align="center">
                <br><br><br><br><br><br>
                <?php // echo utf8_encode($registro[nombre_solicitante]); 
                ?>
                <br>
                <strong>FIRMA SOLICITANTE</strong>
            </td>
            <td width="130" height="80" align="center">
                <br><br><br><br><br><br>
                <?php // echo utf8_encode($registro[unidad_solicitante]); 
                ?>
                <br>
                <strong>JEFE UNIDAD SOLICITANTE</strong>
            </td>
            <td width="130" height="80" align="center">
                <br><br><br><br><br><br>
                <?php // echo utf8_encode($registro[gerente_area]); 
                ?>
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
                        <td align="center"><?php //echo date('d/m/Y'); 
                                            ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table> -->
<?php // } else {
// if ($registro_sol[existencia] == 'NO') { 
?>
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
                    <td align="center"><?php echo date('d/m/Y'); ?> </td>
                </tr>
            </table>
            <!-- <strong>Fecha:__/__/____</strong>
                <br><br>
                <strong>INICIO ADQUISICION <br>RPA</strong> -->
        </td>
    </tr>
</table>
<?php
// include("../reportes/inicio_pagina_logo.php");
if ($tipo == "material") {
    $especificaciones_tecnicas = $bd->Consulta("SELECT s.unidad_solicitante, s.objetivo_contratacion, s.nombre_solicitante, dm.descripcion, dm.id_detalle_material as id_detalle
                FROM solicitud_material as s 
                INNER JOIN detalle_material as dm ON dm.id_solicitud_material = s.id_solicitud_material 
                WHERE s.id_solicitud_material=$id_solicitud");
} elseif ($tipo == "activo") {
    $especificaciones_tecnicas = $bd->Consulta("SELECT s.unidad_solicitante, s.objetivo_contratacion, s.nombre_solicitante, dm.descripcion, dm.id_detalle_activo as id_detalle
                FROM solicitud_activo as s 
                INNER JOIN detalle_activo as dm ON dm.id_solicitud_activo = s.id_solicitud_activo 
                WHERE s.id_solicitud_activo=$id_solicitud");
} elseif ($tipo == "servicio") {
    $especificaciones_tecnicas = $bd->Consulta("SELECT s.unidad_solicitante,s.oficina_solicitante, s.objetivo_contratacion, s.nombre_solicitante, dm.descripcion, dm.id_detalle_servicio as id_detalle
                FROM solicitud_servicio as s 
                INNER JOIN detalle_servicio as dm ON dm.id_solicitud_servicio = s.id_solicitud_servicio 
                WHERE s.id_solicitud_servicio=$id_solicitud");
}
while ($especificacion = $bd->getFila($especificaciones_tecnicas)) {
    echo "</page>";

?>
    <page backtop="18mm" backbottom="14mm" backleft="0mm" backright="0mm" backimg="" style="font-size: 10pt">

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
                        <?php echo date('d/m/Y'); ?>
                    </td>

                </tr>

            </table>

        </page_footer>
        <br><br><br>
        <div class="cabecera">
            <h1 align="center" style="color:white;">FORMULARIO CM - 01 <br> ESPECIFICACIONES TECNICAS
                <br>Nro.
                <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
            </h1>
        </div>
        <table align="center" width="600" class="tabla_reporte">
            <tr>
                <td width="150" class="cabecera-tabla"><strong>DATOS GENERALES DEL REQUERIMIENTO:</strong></td>
                <td width="450"><?php echo strtoupper(utf8_encode($especificacion[descripcion])); ?></td>
            </tr>
            <tr>
                <td width="150" class="cabecera-tabla"><strong>UNIDAD SOLICITANTE:</strong></td>
                <td width="450"><?php echo ($especificacion[oficina_solicitante] != NULL) ? strtoupper(utf8_encode($especificacion[oficina_solicitante])) : strtoupper(utf8_encode($especificacion[unidad_solicitante])); ?></td>
            </tr>
            <tr>
                <td width="150" class="cabecera-tabla"><strong>OBJETIVO DE CONTRATACION:</strong></td>
                <td width="450"><?php echo strtoupper(utf8_decode($especificacion[objetivo_contratacion])) ?></td>
            </tr>
            <tr>
                <td width="150" class="cabecera-tabla"><strong>RESPONSABLE DE ELABORACION:</strong></td>
                <td width="450" colspan="3"><?php echo strtoupper(utf8_encode($especificacion[nombre_solicitante])); ?></td>
            </tr>
        </table>
        <br>
        <table align='center' width="700" class='tabla_reporte'>
            <tr class="cabecera-tabla" align="center">
                <td width="150"><strong class='letra_9'>Nro</strong></td>
                <td width="450"><strong class='letra_9'>TECNICASDESCRIPCION DEL BIEN/SERVICIO</strong></td>
            </tr>
            <?php
            if ($tipo == "material") {
                $especificaciones = $bd->Consulta("SELECT * FROM especificaciones_material WHERE id_detalle_material=$especificacion[id_detalle]");
            } elseif ($tipo == "activo") {
                $especificaciones = $bd->Consulta("SELECT * FROM especificaciones_activo WHERE id_detalle_activo=$especificacion[id_detalle]");
            } else {
                $especificaciones = $bd->Consulta("SELECT * FROM especificaciones_servicio WHERE id_detalle_servicio=$especificacion[id_detalle]");
            }
            $index = 1;
            while ($tecnicismos = $bd->getFila($especificaciones)) { ?>
                <tr>
                    <td class='letra_9' align='center'><?php echo $index; ?></td>
                    <td class='letra_9 descripcion'><?php echo strtoupper(utf8_encode($tecnicismos[especificacion])); ?></td>
                </tr>
            <?php $index++;
            } ?>
        </table>
        <table border="0" width="700">
            <tr>
                <td width="350" height="80" align="center"><br><br><br><br><br><br>__________________________________<br><strong>SELLO Y FIRMA <br>RESPONSABLE ELABORACION DEL FORMULARIO</strong></td>
            </tr>
        </table>
    <?php }
// echo "</page>";
    ?>
    <?php
    // }
    // }

    echo "</page>";
    $content = ob_get_clean();

    try {
        $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("Form2_Form1_Solicitud_" . $id_solicitud . "_tipo_" . $tipo . ".pdf");
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id]);
    ?>