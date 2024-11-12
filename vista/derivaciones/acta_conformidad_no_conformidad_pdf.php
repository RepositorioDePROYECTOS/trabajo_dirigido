<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
require_once('../reportes/cabeza_logo_papeleta.php');
include("../reportes/inicio_pagina_logo.php");
setlocale(LC_TIME, "es_ES");

$id_solicitud  = $_GET[id_solicitud];
$id_detalle    = $_GET[id_detalle];
$tipo          = $_GET[tipo];
$conformidad   = $_GET[conformidad];
$id_requisitos = $_GET[id_requisitos];
$numero_de_orden = "";

// echo $id_solicitud. " - " . $id_detalle . " - " . $tipo . " - " . $conformidad . " - " . $id_requisitos ;

$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'");
$derivacion = $bd->getFila($derivaciones);
// var_dump($derivacion);
// echo "<br>";
// echo "SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'";
// echo "<br>";
// echo "<br>";
$procedimientos = $bd->Consulta("SELECT * FROM procedimientos WHERE id_derivacion=$derivacion[id_derivacion] OR id_requisitos=$id_requisitos");
$procedimiento = $bd->getFila($procedimientos);
// var_dump($procedimiento);
// echo "<br>";
// echo "SELECT * FROM procedimientos WHERE id_derivacion=$derivacion[id_derivacion] OR id_requisitos=$id_requisitos";
// echo "<br>";
// echo "<br>";
$trab2 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]");
$t2 = $bd->getFila($trab2);
// var_dump($t2);
// echo "<br>";
// echo "SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]";
// echo "<br>";
// echo "<br>";
$busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos as s INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
$datos = $bd->getFila($busqueda_requisitos);
// var_dump($datos);
if ($datos[tipo_solicitud] == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.id_partida, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_material as d ON d.id_detalle_material = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_material];
    // echo "ERROR AQUI MATERIAL";
} elseif ($datos[tipo_solicitud] == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    // var_dump($registros_solicitud);
    // echo "<br>";
    // echo "<br>";
    // echo "<br>";
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}
$proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
$proveedor = $bd->getFila($proveedores);
// var_dump($proveedor);
// echo "<br>";
// echo "<br>";
// echo "<br>";

// $requisitos = $bd->getFila($datos_requisitos);
$meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
?>
<style>
    .cabecera {
        background-color: #21A9E1;
        padding: -10px;
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 20px;
    }

    .break {
        page-break-after: always;
    }

    * {
        font-size: 12px;
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
    <h1 align="center" style="color: white;">FORMULARIO CM - <?php echo $conformidad == 'si' ? '08' : '09'; ?>
        <br> <?php echo $conformidad == 'si' ? 'ACTA DE RECEPCION O INFORME DE CONFORMIDAD' : 'ACTA O INFORME DE DISCONFORMIDAD' ?>
        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>
<p>
    De acuerdo a memorandum de fecha <?php echo date('d', strtotime($procedimiento[fecha_elaboracion])) . ' de ' . $meses[date('m', strtotime($procedimiento[fecha_elaboracion])) - 1] . ' de ' . date('Y', strtotime($procedimiento[fecha_elaboracion])) ?>, en cumplimiento a las
    funciones asignadas informamos al respecto del servicio que realizó la empresa <strong><?php echo $proveedor[nombre]; ?></strong> de acuerdo al
    siguiente detalle:
</p>
<br>
<p align="center">
    " SERVICIO DE <?php echo strtoupper(utf8_decode($registro_sol[objetivo_contratacion])) ?>" <?php if ($procedimiento[cuce] != null && strlen($procedimiento[cuce]) > 0) {
                                                                                                    echo " CUCE: " . $procedimiento[cuce];
                                                                                                } ?>
</p>
<p>
    En ese sentido,<?php echo $conformidad == 'si' ? '' : 'NO' ?> habiendo cumplido con las condiciones estipuladas en el Contrato/ Orden de Servicio,
    <?php echo $conformidad == 'si' ? ' emitimos nuestra conformidad .' : ' emito mi disconformidad con el bien o servicio recepcionado.' ?>
</p>
<p>
    Sin otro particular, me despido con las consideraciones más distinguidas.
</p>
<br><br><br>
<p>
    <strong>Lugar y fecha: </strong>Sucre <?php echo date('d') . ' de ' . $meses[date('m') - 1] . ' de ' . date('Y')  ?>
</p>

<br><br><br><br><br><br><br>
<?php if ($conformidad == 'si') { ?>
    <table width="600" align="center">
        <tr>
            <td width="300">
                <strong align="center">RESPONSABLE O COMISIÓN DE RECEPCIÓN</strong>
            </td>
            <td width="300">
                <strong align="center">TECNICO Y JEFE INMEDIATO SUPERIOR DE UNIDAD ESPECIALIZADA</strong>
            </td>
        </tr>
    </table>
<?php } else { ?>
    <p align="center">
        <strong align="center">RESPONSABLE O COMISIÓN DE RECEPCIÓN</strong>
    </p>
<?php } ?>

<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Acta_de_Consformidad_Solicitud_".$id_solicitud."_tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>