<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
require_once('../reportes/cabeza_logo_papeleta.php');
include("../reportes/inicio_pagina_logo.php");
setlocale(LC_TIME, "es_ES");

// $id_solicitud  = $_GET[id_solicitud];
// $id_detalle    = $_GET[id_detalle];
// $tipo          = $_GET[tipo];
// $numero_de_orden = "";

// $busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos as s INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
// $datos = $bd->getFila($busqueda_requisitos);
// if ($datos[tipo_solicitud] == 'material') {
//     $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
//     $registro_sol = $bd->getFila($registros_solicitud);
//     $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.id_partida, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_material as d ON d.id_detalle_material = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
//     $numero_de_orden = $registro_sol[nro_solicitud_material];
//     // echo "ERROR AQUI MATERIAL";
// } elseif ($datos[tipo_solicitud] == 'activo') {
//     $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
//     $registro_sol = $bd->getFila($registros_solicitud);
//     $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
//     $numero_de_orden = $registro_sol[nro_solicitud_activo];
//     // echo "ERROR AQUI ACTIVO";
// } else {
//     $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
//     $registro_sol = $bd->getFila($registros_solicitud);
//     $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
//     $numero_de_orden = $registro_sol[nro_solicitud_servicio];
//     // echo "ERROR AQUI SERVICIO";
// }
// $proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
// $proveedor = $bd->getFila($proveedores);

// $requisitos = $bd->getFila($datos_requisitos);
?>
<style>
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
</style>
<div class="cabecera">
    <h1 align="center" style="color: white;">
        FORMULARIO CM - 13
        <br>
        PLANILLA DE ALIMENTACIÓN
    </h1>
</div>

<table align="center" width="840" class="tabla_reporte">
    <tr>
        <td width="200" class="cabecera-tabla"><strong>UNIDAD SOLICITANTE:</strong></td>
        <td width="640"></td>

    </tr>
    <tr>
        <td width="200" class="cabecera-tabla"><strong>ACTIVIDAD O EVENTO:</strong></td>
        <td width="640"></td>

    </tr>
    <tr>
        <td width="200" class="cabecera-tabla"><strong>LUGAR Y FECHA :</strong></td>
        <td width="640"></td>

    </tr>
</table>
<br>
<table align="center" width="800" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td width="20" align="center" rowspan="2"> <strong class="letra_9">Nro </strong></td>
        <td width="280" align="center" rowspan="2"> <strong class="letra_9">Nombre </strong></td>
        <td width="100" align="center" rowspan="2"> <strong class="letra_9">Institucion </strong></td>
        <td width="400" align="center" colspan="2"> <strong class="letra_9">Firma </strong></td>
    </tr>
    <tr class="cabecera-tabla">
        <td width="200" align="center">Mañana</td>
        <td width="200" align="center">Tarde</td>
    </tr>
    <?php
    $n = 0;
    $total = 100;
    while ($n < $total ) {
        $n++;
    ?>
        <tr >
            <td width="50" height="30" style="font-size: 12pt" align="center"><?php echo $n; ?> </td>
            <td width="150" class="letra_9" align="center"> </td>
            <td width="100" class="letra_9" align="center"> </td>
            <td width="150" class="letra_9" align="center"> </td>
            <td width="150" class="letra_9" align="center"> </td>
        </tr>
    <?php
    }
    ?>
</table>
<table align="center" width="600" class="tabla_reporte">
    <tr>
        <td width="300" align="center"> <br><br><br><br><br><br><br><br><br><br><br> <strong>UNIDAD SOLICITANTE</strong></td>
        <td width="300" align="center"> <br><br><br><br><br><br><br><br><br><br><br> <strong>JEFE INMEDIATO SUPERIOR <br> VoBo</strong></td>
    </tr>

</table>
<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('L', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('papeleta_solicitud_material.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>