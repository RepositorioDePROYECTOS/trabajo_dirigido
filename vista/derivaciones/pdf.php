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
$tipo          = $_GET[tipo];
$numero_de_orden = "";

$busqueda_requisitos = $bd->Consulta("SELECT * FROM requisitos as s INNER JOIN  derivaciones as d ON s.id_solicitud=d.id_solicitud WHERE s.id_solicitud=$id_solicitud AND s.id_detalle=$id_detalle");
$datos = $bd->getFila($busqueda_requisitos);
if ($datos[tipo_solicitud] == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.id_partida, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_material as d ON d.id_detalle_material = r.id_detalle  LEFT JOIN partidas as p ON p.id_partida = d.id_partida  WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_material];
    // echo "ERROR AQUI MATERIAL";
} elseif ($datos[tipo_solicitud] == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle  LEFT JOIN partidas as p ON p.id_partida = d.id_partida  WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle  LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}
$proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
$proveedor = $bd->getFila($proveedores);

// $requisitos = $bd->getFila($datos_requisitos);
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

    .salto-texto {
        word-break: break-all;
    }
</style>
<div class="cabecera">
    <h1 align="center" style="color:white;">FORMULARIO CM - <?php if ($tipo == 'servicio') {
                                                                echo "04";
                                                            } else {
                                                                echo "03";
                                                            } ?> <?php //echo $id_solicitud." - ".$id_detalle;
                                                                    ?>
        <br>ORDEN DE <?php if ($tipo == 'servicio') {
                            echo "SERVICIO";
                        } else {
                            echo "COMPRA";
                        } ?>

        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>

<table align="center" width="650" class="tabla_reporte">
    <tr>
        <td width="120"><strong>Proceso de Contratación:</strong></td>
        <td width="280"><?php echo $registro_sol[justificativo] ?></td>
        <td width="160"><strong>FECHA DE ORDEN:</strong></td>
        <td width="90"><?php echo date("d-m-Y");?></td>
    </tr>
    <tr>
        <td width="120"><strong>OBJETO:</strong></td>
        <td width="280"><?php echo ($registro_sol[objetivo_contratacion] != NULL) ? strtoupper(utf8_encode($registro_sol[objetivo_contratacion])) : "NINGUNO"; ?></td>
        <td width="160" rowspan="2" colspan="2"></td>
    </tr>
    <tr>
        <td width="120"><strong>OFICINA SOLICITANTE:</strong></td>
        <td width="280"><?php echo ($registro_sol[oficina_solicitante] != null) ? strtoupper(utf8_encode($registro_sol[oficina_solicitante])) : strtoupper(utf8_encode($registro_sol[unidad_solicitante])); ?></td>

    </tr>
    <tr>
        <td width="120" colspan="2"></td>
        <td width="120"><strong>Elaborado por:</strong></td>
        <td width="90">FIRMA Y SELLO</td>
    </tr>
</table>
<table align="center" width="650" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td colspan="4" align="left">DATOS DEL PROVEEDORDESCRIPCION</td>
    </tr>
    <tr>
        <td width="120"><strong>Nombre o Razón Social:</strong></td>
        <td width="280"><?php echo strtoupper(utf8_encode($proveedor[nombre])) ?></td>
        <td width="160"><strong>NIT/CI:</strong></td>
        <td width="90"><?php echo strtoupper(utf8_encode($proveedor[nit])) ?></td>
    </tr>
    <tr>
        <td width="120"><strong>Dirección:</strong></td>
        <td width="280"><?php echo strtoupper(utf8_encode($proveedor[direccion])) ?></td>
        <td width="160"><strong>Teléfono:</strong></td>
        <td width="90"><?php echo ($proveedor[telefono] != 0) ? utf8_encode($proveedor[telefono]) : utf8_encode($proveedor[celular]) ?></td>
    </tr>
    <tr>
        <td colspan="4">Sírvanse dar cumplimiento a la provisión de los bienes que se detallan a continuación:</td>
    </tr>
</table>
<table align="center" width="600" class="tabla_reporte">
    <tr class="cabecera-tabla">
        <td width="10" align="center"> <strong class="letra_9 salto-texto">Nro </strong></td>
        <td width="60" align="center"> <strong class="letra_9 salto-texto">Cantidad </strong></td>
        <td width="60" align="center"> <strong class="letra_9 salto-texto">Unidad </strong></td>
        <td width="370" align="center"> <strong class="letra_9 salto-texto">Descripcion </strong></td>
        <!-- <td width="150" align="center"> <strong class="letra_9 salto-texto">Partida Presupuestaria </strong></td> -->
        <td width="60" align="center" class="salto-texto"> <strong class="letra_9">Precio Unitario <br>(BS.) </strong></td>
        <td width="60" align="center" class="salto-texto"> <strong class="letra_9">Precio Total <br>(BS.) </strong></td>
    </tr>
    <?php
        $total = 0;
        while ($registro_s = $bd->getFila($datos_requisitos)) {
        $n++; 
        $cantidad = floatval($registro_s[cantidad_solicitada]) ? intval($registro_s[cantidad_solicitada]) : $registro_s[cantidad_solicitada];
        $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
        $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
    ?>
        <tr>
            <td width="10" class="letra_9  salto-texto" align="center"> <?php echo utf8_encode($n) ?></td>
            <td width="60" class="letra_9  salto-texto" align="center"> <?php echo $cantidad; ?></td>
            <td width="60" class="letra_9  salto-texto" align="center"> <?php echo strtoupper(utf8_encode($registro_s[unidad_medida])) ?></td>
            <td width="370" class="letra_9 salto-texto" align="center"> <?php echo strtoupper(utf8_encode($registro_s[descripcion])) ?></td>
            <!-- <td width="150" class="letra_9 salto-texto" align="center"> <?php echo strtoupper(utf8_encode($registro_s[nombre_partida])) ?></td> -->
            <td width="60" class="letra_9  salto-texto" align="right"> <?php echo $precio_unitario; ?></td>
            <td width="60" class="letra_9  salto-texto" align="right"> <?php echo $precio_total; ?></td>
        </tr>
    <?php $total = $total + $registro_s[precio_total];
    }
    ?>
    <tr>
        <td colspan="5"  align="right"><strong>TOTAL</strong></td>
        <td align="right" ><?php echo number_format($total, 2, ',', '.'); ?></td>
    </tr>
    <tr>
        <td colspan="6" >
            <strong>SON <?php echo numeroALetras($total); ?></strong>
        </td>
    </tr>
</table>
<table align="center" width="600" class="tabla_reporte">
    <tr>
        <td width="170"><strong>MODALIDAD DE CONTRATACIÓN</strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[modalidad_contratacion])); ?></td>
    </tr>
    <tr class="cabecera-tabla">
        <td colspan="2" align="center"><strong>CONDICIONES</strong></td>
    </tr>
    <tr>
        <td width="170"><strong>Plazo de Entrega: </strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[plazo_entrega])); ?></td>
    </tr>
    <tr>
        <td width="170"><strong>Forma de Adjudicacion: </strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[forma_adjudicacion])); ?></td>
    </tr>
    <tr>
        <td width="170"><strong>Multas: </strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[multas_retraso])); ?></td>
    </tr>
    <tr>
        <td width="170"><strong>Forma de Pago: </strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[forma_pago])); ?></td>
    </tr>
    <tr>
        <td width="170"><strong>Lugar de Entrega: </strong></td>
        <td width="510"><?php echo strtoupper(utf8_encode($datos[lugar_entrega])); ?></td>
    </tr>
    <tr class="titulo">
        <td colspan="2" width="670"><strong>OBSERVACIONES Y/O RECOMENDACIONES: LA EMPRESA ADJUDICADA DEBERA COORDINAR CON EL EL RESPONSABLE O COMISIÓN DE RECEPCIÓN Y LA UNIDAD DE ACTIVOS FIJOS O ALMACENES A FIN DE DAR CONFORMIDAD CON LOS BIENES ENTREGADOS.</strong></td>
    </tr>
</table>
<br><br><br><br>
<table align="center" width="600" class="tabla_reporte">
    <tr>
        <td width="200" height="80" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>GERENTE ADMINISTRATIVO Y FINANCIERO</strong></td>
        <td width="200" height="80" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>RESPONSABLE DE ADQUISICIONES</strong></td>
        <td width="200" height="80" align="center"><br><br><br><br><br><br>_____________________________________<br><strong>PROVEEDOR</strong></td>
    </tr>
</table>
<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Inicio_del_proceso_Solicitud_".$id_solicitud."_tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>