<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
require_once('../reportes/cabeza_logo_papeleta.php');
require_once('../reportes/numero_a_letras.php');
include("../reportes/inicio_pagina_logo.php");
setlocale(LC_TIME, "es_ES");
$observaciones = utf8_decode($_GET["observaciones"]);
$id_solicitud  = $_GET[id_solicitud];
$id_detalle    = $_GET[id_detalle];
$tipo          = $_GET[tipo];
$id_requisitos = $_GET[id_requisitos];
$id_proveedor  = $_GET[id_proveedor];
$dato          = $_GET["datos"];
$datos         = json_decode(stripslashes($dato), true);
$tope          = $_GET[tope];
$tipo          = $_GET[tipo];
$numero_de_orden = "";
// echo "convertido <br>";
// print_r($datos);
// echo "<br> normal <br>";
// print_r($dato);
if (is_array($datos)) {
    foreach ($datos as $key) {
        list($id_detalles, $entrega, $stock) = explode('-', $key); // Usar $key en lugar de $data
        if($tipo == "material"){
            $buscar = $bd->Consulta("UPDATE detalle_material SET cantidad_despachada = '$entrega', cantidad_stock = '$stock' WHERE id_detalle_material = $id_detalles");
        } elseif($tipo == "activo") {
            $buscar = $bd->Consulta("UPDATE detalle_activo set cantidad_despachada = '$entrega', cantidad_stock = '$stock' WHERE id_detalle_activo = $id_detalle");
        }
        // echo "id_detalles: ".$id_detalles." entrega: ".$entrega." stock: ".$stock;
    }
}

// print_r($datos);

$busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos as s INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
$datos = $bd->getFila($busqueda_requisitos);
$proveedores = $bd->Consulta("SELECT nombre, nit FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
$proveedor   = $bd->getFila($proveedores);

// $registro_derivacion = $bd->Consulta("UPDATE derivaciones");

if ($tipo == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT *, nro_solicitud_material as nro_solicitud FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, p.codigo_partida, d.precio_unitario, d.precio_total, d.cantidad_stock, d.cantidad_despachada 
        FROM requisitos as r 
        INNER JOIN detalle_material as d ON d.id_detalle_material = r.id_detalle 
        left join partidas p on d.id_partida=p.id_partida 
        WHERE r.id_solicitud=$id_solicitud 
        AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_material];
    // echo "ERROR AQUI MATERIAL";
} elseif ($tipo == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT *, nro_solicitud_activo as nro_solicitud FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total, d.cantidad_stock, d.cantidad_despachada FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT *, nro_solicitud_servicio as nro_solicitud FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}
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
        width: 750px;
    }
    /* table.td {
        word-break: break-all;
    } */

    td.descripcion {
        width: 392px;
        word-wrap: break-word;
    }

    .cabecera {
        background-color: #21A9E1;
        /* background-color: #21A9E1;
        color: white; */
        padding: -5px;
        margin-left: 1px;
        margin-right: 9px;
        margin-bottom: 5px;
        width: 788px;
    }

    .cabecera-tabla {
        background-color: #21A9E1;
        color: white;
    }
</style>
<div class="cabecera">
    <h1 align="center" style="color: white;">
        FORMULARIO CM - 10
        <br>
        FORMULARIO DE INGRESO Y EGRESO DE ALMACENES
        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>

<table align="center" class="tabla_reporte" width="800">
    <tr class="cabecera-tabla">
        <td width="90">Unidad Ejecutora</td>
        <td width="550"><?php echo ($registro_sol[unidad_solicitante] != NULL) ? utf8_encode($registro_sol[unidad_solicitante]) : utf8_encode($registro_sol[oficina_solicitante]) ;?></td>
        <!-- <td width="100"></td> -->
        <td width="90" align="right">Sucre, <?php echo date('d-m-Y'); ?></td>
    </tr>
</table>
<table align="center" width="600" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td width="600" colspan="11" align="center">Ingreso</td>
    </tr>
    <tr class="cabecera-tabla" align="center">
        <td width="20">N°</td>
        <td width="50">Partida Presupuestaria</td>
        <td width="150">Detalle</td>
        <td width="30">N° Orden Compra</td>
        <td width="30">Cantidad</td>
        <td width="30">Unidad</td>
        <td width="40">Precio <br> Unitario</td>
        <td width="40">Precio Total Facturado</td>
        <td width="40">IVA 13%</td>
        <td width="40">Total Almacen</td>
        <td width="130">Proveedor</td>
    </tr>
    <?php 
        $n=1; 
        $total=0;
        $total_iva = 0;
        $total_almacen = 0;
        while($pdf = $bd->getFila($datos_requisitos))
        {
            $cantidad = floatval($pdf[cantidad_solicitada]) ? intval($pdf[cantidad_solicitada]) : $pdf[cantidad_solicitada];
            $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
            $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
    ?>
    <tr align="center">
        <td width="20"> <?php echo $n;?></td>
        <td width="50"> <?php echo $pdf[codigo_partida]; ?></td>
        <td width="150"><?php echo $pdf[descripcion]; ?></td>
        <td width="30"> <?php echo $registro_sol[nro_solicitud]; ?></td>
        <td width="30"> <?php echo $cantidad; ?></td>
        <td width="30"> <?php echo utf8_encode($pdf[unidad_medida]); ?></td>
        <td width="40"> <?php echo number_format($pdf[precio_unitario], 2, ',', '.'); ?></td>
        <td width="40"> <?php echo number_format($pdf[precio_total], 2, ',', '.'); ?></td>
        <td width="40"> <?php $iva=$pdf[precio_total]*0.13; echo number_format($iva, 2, ',', '.'); ?></td>
        <td width="40"> <?php $costo_almacen=$pdf[precio_total]-$iva; echo number_format($costo_almacen, 2, ',', '.'); ?></td>
        <td width="130"> <?php echo utf8_encode($proveedor[nombre]); ?><br><?php echo utf8_encode($proveedor[nit]); ?></td>
    </tr>
    <?php
        $n++; 
        $total=$total + $pdf[precio_total]; 
        $total_iva = $total_iva + $iva;
        $total_almacen = $total_almacen + $costo_almacen;  
        }
    ?>
    <tr>
        <td colspan="7">TOTAL:</td>
        <td><?php echo number_format($total, 2, ',', '.');?></td>
        <td><?php echo number_format($total_iva,  2, ',', '.');?></td>
        <td><?php echo number_format($total_almacen,  2, ',', '.');?></td>
        <td></td>
    </tr>
    <?php if (strlen($observaciones) > 0) { ?>
        <tr>
            <td colspan="11" align="left">
                <strong>Observcaiones: </strong> <?php echo $observaciones; ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="11" style="word-break: break-all;">
            Para Contrataciones hasta Bs. 20.000.- La Unidad Solicitante se constituye en RESPONSABLE DE RECEPCIÓN, que habiendo verificado el cumplimiento de las especificaciones técnicas, de acuerdo a Contrato u Orden de Compra, procedo a emitir mi CONFORMIDAD del Bien Adquirido, en constancia firmo el presente formulario.
        </td>
    </tr>
    <tr>
        <td colspan="5" align="left">PARA INGRESO</td>
        <td colspan="6" align="left">Conformidad de Recepción</td>
    </tr>
    <tr>
        <td colspan="5" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>Responsable o Comision de Recepcion</strong></td>
        <td colspan="6" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>Responsable de Almacenes</strong></td>
    </tr>
    <tr>
        <td colspan="5" align="left">PARA EGRESO</td>
        <td colspan="6" align="left">Conformidad de Recepción</td>
    </tr>
    <tr>
        <td colspan="5" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>Responsable de Almacenes</strong></td>
        <td colspan="6" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>Responsable o Comision de Recepcion</strong></td>
    </tr>
    <tr align="center" class="cabecera-tabla">
        <td colspan="11">Verificacion de Unidad Especializada si corresponde</td>
    </tr>
    <tr>
        <td colspan="11"><br><br><br></td>
    </tr>
    <tr>
        <td colspan="11"><br><br><br></td>
    </tr>
    <tr>
        <td colspan="4"><br><br><br><br><br><br><br><br></td>
        <td colspan="2"></td>
        <td colspan="1"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>
    <tr align="center" class="cabecera-tabla">
        <td colspan="4">Tecnico de Sistemas</td>
        <td colspan="2">vºBº Jefe de Sistemas <br> Informaticos</td>
        <td colspan="1"></td>
        <td colspan="2">Tecnico otra unidad <br> especializada</td>
        <td colspan="2">vºbº Jefe de Otra Unidad especializada si <br> corresponde</td>
    </tr>
</table>
<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(5, 0, 5, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Ingreso_y_Egreso_de_la_solicitud_tipo_".$tipo."_nro_".$id_solicitud.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>