<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
// require_once('../reportes/cabeza_logo_papeleta.php');
// include("../reportes/inicio_pagina_logo.php");
require_once("../../modelo/conexion.php");
require_once("../../modelo/entidad.php");
require_once("../../modelo/funciones.php");
setlocale(LC_TIME, "es_ES");
$bd = new conexion();

$entidad = new entidad();
$entidad->get_entidad_defecto();

$id_solicitud  = $_GET[id_solicitud];
$id_detalle    = $_GET[id_detalle]; //Array
$id_requisitos = $_GET[id_requisitos];
$tipo          = $_GET[tipo];
$fecha             = date('Y-m-d H:i:s');
$numero_de_orden = "";

$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'");
$derivacion = $bd->getFila($derivaciones);
// var_dump($derivacion);
$procedimientos = $bd->Consulta("SELECT * FROM procedimientos WHERE id_requisitos=$id_requisitos AND id_derivacion=$derivacion[id_derivacion]");
// $procedimiento = $bd->getFila($procedimientos);

// $trab1 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[responsable]");
// $t1 = $bd->getFila($trab1);

// $trab2 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]");
// $t2 = $bd->getFila($trab2);
if ($tipo == "material") {
    $solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $sol = $bd->getFila($solicitud);
    $numero_de_orden = $sol[nro_solicitud_material];
} elseif ($tipo == "activo") {
    $solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $sol = $bd->getFila($solicitud);
    $numero_de_orden = $sol[nro_solicitud_activo];
} else {
    $solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio=$id_solicitud");
    $sol = $bd->getFila($solicitud);
    $numero_de_orden = $sol[nro_solicitud_servicio];

}

?>
<style>
    * {
        font-size: 11px;
    }

    tr.rojo {
        background: #FED4D4;
    }

    .left {
        margin-left: 60px;
    }

    table.page_header {
        width: 100%;
        border: none;
        padding: 10px 10px 0px 10px;
        color: #223B50;
        font-size: 10px;
    }

    table.page_footer {
        width: 100%;
        height: 93px;
        border: none;
        padding: 25px 10px;
        color: #223B50;
        font-size: 10px;
    }

    table.cont tr.titulo {
        background: #223B50;
        color: #FFF;
        text-align: center;
        vertical-align: middle;
        font-size: 8px;
        text-transform: uppercase;
    }

    tr.titulo4 {
        color: #223B50;
        text-shadow: 0px 1px 0px #fff;
        background: #f5f5f5;
    }

    table.cont {
        width: 100%;
        border-left: solid 1px #223B50;
        border-top: solid 1px #223B50;
        background: #fff;
        font-size: 8px;
    }

    table.cont td {
        border-bottom: solid 1px #223B50;
        border-right: solid 1px #223B50;
        padding: 5px;
        font-size: 10px;
    }

    table.cont thead td {
        border-bottom: solid 1px #828587;
        border-right: solid 1px #828587;
        padding: 5px;
        font-size: 10px;
    }

    tr.fila1 {
        background: #f0f0f0;
    }

    tr.fila2 {
        background: #fff;
    }

    tr.fila3 {

        background: #eee;

    }

    h3 {

        display: block;

        text-align: center;

        color: #444;

        font-size: 14px;

        font-weight: normal;

    }

    h1 {

        display: block;

        text-align: center;

        color: #223B50;

        font-size: 14px;

    }

    p {
        padding: 0px 40px;
        text-align: justify;
        line-height: 20px;
        margin: 5px 0;
    }

    p.parrafo {
        margin-left: 15px;
    }

    .bg-red {
        background: #FFAAAA;
    }

    table.tabla_reporte {
        width: 100%;
        border: solid 1px #888;
        background: #fff;
        font-size: 9px;
        border-collapse: collapse;
    }

    table.tabla_reporte td {
        border: solid 1px #888;
        padding: 2px 3px;
    }

    table.tabla_reporte thead td {
        border: solid 1px #888;
        padding: 3px;
    }

    table.tabla_reporte tr.titulo {
        background: #ddd;
        text-transform: uppercase;
    }

    .moneda {
        text-align: right;
    }

    .cabecera {
        background-color: #21A9E1;
        padding: -5px;
        margin-left: 80px;
        margin-right: 60px;
        margin-bottom: 20px;
    }

    .break {
        page-break-after: always;
    }

    .tamanio {
        font-size: 12px;
    }

    .tamanio1 {
        font-size: 14px;
        word-wrap: break-word;
    }

    table {
        table-layout: fixed;
        width: 600px;
    }

    p {
        /* font-size: 13px; */
        /* font-weight: bold; */
        /* word-wrap: break-word; */
    }

    td.descripcion {
        width: 392px;
        word-wrap: break-word;
    }
</style>
<?php while ($procedimiento = $bd->getFila($procedimientos)) {
    $trab1 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[responsable]");
    $t1 = $bd->getFila($trab1);

    $trab2 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]");
    $t2 = $bd->getFila($trab2);

?>

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

        <div class="cabecera">
            <h1 align="center" style="color: white;">
                FORMULARIO CM - 06
                <br>
                MEMORANDUN
                <br>Nro.
                <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
            </h1>
        </div>

        <table align="center" width="600" border="0">
            <tr>
                <td width="5"></td>
                <td width="210" align="right" class="tamanio">DE:</td>
                <td width="380" class="tamanio"><?php echo $t1[nombres] . " " . $t1[apellido_paterno] . " " . $t1[apellido_materno] ?></td>
                <td width="5"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td width="5"></td>
                <td width="210" align="right" class="tamanio">A:</td>
                <td width="380" class="tamanio"><?php echo $t2[nombres] . " " . $t2[apellido_paterno] . " " . $t2[apellido_materno] ?></td>
                <td width="5"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td width="5"></td>
                <td width="210" align="right" class="tamanio">REF:</td>
                <td width="380" class="tamanio">DESIGNACIÓN RESPONSABLE O COMISIÓN DE RECEPCIÓN</td>
                <td width="5"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td width="5"></td>
                <td width="210" align="right" class="tamanio">FECHA:</td>
                <td width="380" class="tamanio">Sucre, <?php echo date('d-m-Y', strtotime($procedimiento[fecha_elaboracion])) ?></td>
                <td width="5"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________________________________________________________________________________________
        </p>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Señor:
        </p>
        <br>
        <br>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conforme a lo estipulado en las Normas Basicas del Sistema de Administracion de Bienes y Servicios, designo a su persona como: <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RESPONSABLE O COMISION DE RECEPCIÓN del proceso de contratación:
        </p>
        <p style="text-decoration: underline;" align="center">
            "<?php echo utf8_encode(strtoupper($sol[objetivo_contratacion])); ?>" <?php if (($procedimiento[cuce]) != null) { ?>con CUCE: <?php echo $procedimiento[cuce];
                                                                                                                                        } ?></p>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El RESPONSABLE O COMISION DE RECEPCIÓN, deberá cumplir las funciones establecidas en el parágrafo II del Art. 39 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;del Decreto Supremo Nº 181 y no
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;podrá excusarse de participar, salvo las causales establecidas en el Articulo 41 del mencionado Decreto Supremo.
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El Acta de Recepción y/o Acta de Conformidad ó Informe de Conformidad o Disconformidad deberá ser remitido a la Unidad
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrativa, para proceder según corresponda, conforme a normas vigentes.Sin otro particular, me despido con las consideraciones
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;más distinguidas.
        </p>
        <br><br><br><br><br><br><br><br><br>
        <p align="center">
            ______________________________________ <br>
            AUTORIDAD RESPONSABLE DEL PROCESO <br> DE CONTRATACIÓN (RPA)
        </p>

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
    </page>
<?php } ?>
<?php
// echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(5, 0, 5, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Memorandun_" . $tipo . "_solicitud_" . $id_solicitud . ".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>