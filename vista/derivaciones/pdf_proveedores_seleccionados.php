<?php
    session_start();
    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    require_once('../reportes/cabeza_logo_papeleta.php');
    require_once('../reportes/numero_a_letras.php');
    include("../reportes/inicio_pagina_logo.php");
    setlocale(LC_TIME, "es_ES");

    $id_solicitud   = $_GET[id_solicitud];
    $id_proveedor   = $_GET[id_proveedor];
    $tipo           = $_GET[tipo];
    $id_detalle     = $_GET[id_detalle];
    $numero_de_orden = "";

    $busqueda_requisitos = $bd->Consulta("SELECT * 
        FROM requisitos as s 
        INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud 
        WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
    $datos = $bd->getFila($busqueda_requisitos);
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
        $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
        $numero_de_orden = $registro_sol[nro_solicitud_servicio];
        // echo "ERROR AQUI SERVICIO";
    }
    $proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
    $proveedor = $bd->getFila($proveedores);

    // $requisitos = $bd->getFila($datos_requisitos);
    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    // print_r($datos_requisitos)
    // $requisitos = $bd->Consulta("SELECT id_requisitos FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor");
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
    .tamanio {
        font-size: 12px;
    }
    .left {
        text-align: left;
    }
    .right {
        text-align: right;
    }
    .center {
        text-align: center;
    }
</style>
<div class="cabecera-tabla">
    <h1 align="center" style="color:white;">INFORME DE ADJUDICACION
    <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>


</div>


<p class="tamanio">
    <strong>El Proveedor:</strong> <br> 
</p>
<p class="tamanio center">
<?php echo "<strong>" . utf8_encode($proveedor[nombre])." con NIT: ".utf8_encode($proveedor[nit])."</strong>" ?>
</p>
<p class="tamanio left">
    Cumple con lo requerido por la unidad Solicitante, por lo tanto se recomienda la adjudicacion de:<br>
    <ul>
        <li class="center">
            <?php echo "<strong>".utf8_encode($registro_sol[objetivo_contratacion])."</strong>" ?>
        </li>
    </ul>
</p>
<p class="tamanio">
    Con el siguiente detalle
</p>
<h3 align="center">DETALLES DEL PROCESO DE ADQUISICION</h3>

<?php $total = 0;?>
<table align="center" width="570" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td width="10" align="center"> <strong class="tamanio">Nro </strong></td>
        <td width="300" align="center"> <strong class="tamanio">Descripcion </strong></td>
        <td width="60" align="center"> <strong class="tamanio">Cantidad </strong></td>
        <td width="60" align="center"> <strong class="tamanio">Unidad </strong></td>
        <td width="70" align="center"> <strong class="tamanio">Precio Unitario <br>(BS.) </strong></td>
        <td width="70" align="center"> <strong class="tamanio">Precio Total <br>(BS.) </strong></td>
    </tr>
    <?php
    
    while ($registro_s = $bd->getFila($datos_requisitos)) {
        $n++; 
        $cantidad = floatval($registro_s[cantidad_solicitada]) ? intval($registro_s[cantidad_solicitada]) : $registro_s[cantidad_solicitada];
        $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
        $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
        ?>
        <tr>
            <td width="10" class="tamanio" align="center"> <?php echo utf8_encode($n) ?></td>
            <td width="300" class="tamanio" align="center"> <?php echo utf8_encode($registro_s[descripcion]) ?></td>
            <td width="60" class="tamanio" align="center"> <?php echo $cantidad; ?></td>
            <td width="60" class="tamanio" align="center"> <?php echo utf8_encode($registro_s[unidad_medida]) ?></td>
            <td width="70" class="tamanio" align="right"> <?php echo $precio_unitario; ?></td>
            <td width="70" class="tamanio" align="right"> <?php echo $precio_total; ?></td>
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
</table>
<?php 
    $requisitos_detallados = $bd->Consulta("SELECT * FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor");
    $r_detallados = $bd->getFila($requisitos_detallados);
?>
<table border="0" align="center">
    <tr>
        <td>Por Bs.</td>
        <td><?php echo $total?></td>
    </tr>
    <tr>
        <td>Tiempo de Entrega</td>
        <td><?php echo utf8_encode($r_detallados[plazo_entrega])?></td>
    </tr>
    <tr>
        <td>Forma de Adjudicación</td>
        <td><?php echo utf8_encode($r_detallados[forma_adjudicacion])?></td>
    </tr>
    <tr>
        <td colspan="2">Salve mejor criterio.</td>
    </tr>
</table>
<p align="left">Sucre, <?php echo date('d') . ' de ' . $meses[date('m') - 1] . ' de ' . date('Y') ?></p>

<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Nota_de_Proveedores_Seleccionados_solicitud_".$id_solicitud."_tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>