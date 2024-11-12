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
$aclaracion    = $_GET[aclaracion];

$numero_de_orden = "";
$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'");
$derivacion = $bd->getFila($derivaciones);
// var_dump($derivacion);
// echo "<br>";
// echo "<br>";
// echo "<br>";
$procedimientos = $bd->Consulta("SELECT * FROM procedimientos WHERE id_requisitos=$id_requisitos AND id_derivacion=$derivacion[id_derivacion]");
$procedimiento = $bd->getFila($procedimientos);
// var_dump($procedimiento);
// echo "<br>";
// echo "<br>";
// echo "<br>";
$trab2 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]");
$t2 = $bd->getFila($trab2);
// var_dump($t2);
// echo "<br>";
// echo "<br>";
// echo "<br>";
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
    $datos_requisitos = $bd->Consulta("SELECT d.id_detalle_activo as id_detalle,  d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_activo as d ON d.id_detalle_activo = r.id_detalle LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_activo];
    // echo "ERROR AQUI ACTIVO";
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $registro_sol = $bd->getFila($registros_solicitud);
    $datos_requisitos = $bd->Consulta("SELECT d.id_detalle_servicio as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, d.precio_unitario, d.precio_total,p.nombre_partida FROM requisitos as r INNER JOIN detalle_servicio as d ON d.id_detalle_servicio = r.id_detalle LEFT JOIN partidas as p ON p.id_partida = d.id_partida WHERE r.id_solicitud=$id_solicitud AND r.id_proveedor=$datos[id_proveedor]");
    $numero_de_orden = $registro_sol[nro_solicitud_servicio];
    // echo "ERROR AQUI SERVICIO";
}
$proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
$proveedor = $bd->getFila($proveedores);

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

    table.tabla_informe {
        width: 600px;
        border: solid 1px #888;
        background: #fff;
        font-size: 9px;
        border-collapse: collapse;
    }

    table.tabla_informe td {
        border: solid 1px #888;
        /* padding: 2px 3px; */
    }

    table.tabla_informe thead td {
        border: solid 1px #888;
        /* padding: 3px; */
    }

    table.tabla_informe tr.titulo {
        background: #ddd;
        text-transform: uppercase;
    }
</style>
<div class="cabecera">
    <h1 style="color:white;" align="center">FORMULARIO CM - 07 <?php //echo $id_solicitud." - ".$id_detalle;
                                                                ?>
        <br>ACTA DE RECEPCIÓN Y/O ACTA DE CONFORMIDAD
        <br>Nro.
        <?php echo str_pad($numero_de_orden, 6, "0", STR_PAD_LEFT); ?>
    </h1>
</div>
<p>
    En la ciudad de Sucre, en fecha <?php echo date('d', strtotime($procedimiento[fecha_elaboracion])) . ' de ' . $meses[date('m', strtotime($procedimiento[fecha_elaboracion])) - 1] . ' de ' . date('Y', strtotime($procedimiento[fecha_elaboracion])) ?> en instalaciones de la Oficina Central de ELAPAS ubicada en la Avenida Jaime Mendoza N° 850, el señor <strong><?php echo $t2[nombres] . " " . $t2[apellido_paterno] . " " . $t2[apellido_materno] ?></strong> designado como
    Responsable de Recepcion efectuo la <strong> RECEPCIÓN </strong> de bienes, de acuerdo al siguiente detalle:
</p>
<table align="center" width="630" class="tabla_informe">
    <tr class="cabecera-tabla">
        <td colspan="4" align="left">DATOS DEL PROVEEDOR</td>
    </tr>
    <tr>
        <td width="150"><strong>Nombre o Razón Social:</strong></td>
        <td width="230"><?php echo utf8_encode($proveedor[nombre]) ?></td>
        <td width="160"><strong>NIT/CI:</strong></td>
        <td width="90"><?php echo utf8_encode($proveedor[nit]) ?></td>
    </tr>
    <tr>
        <td width="150"><strong>Dirección:</strong></td>
        <td width="230"><?php echo utf8_encode($proveedor[direccion]) ?></td>
        <td width="160"><strong>Teléfono:</strong></td>
        <td width="90"><?php echo ($proveedor[telefono] != 0) ? utf8_encode($proveedor[telefono]) : utf8_encode($proveedor[celular]) ?></td>
    </tr>
    <tr>
        <td width="150"><strong>Objeto:</strong></td>
        <td width="230"><?php echo utf8_encode($registro_sol[objetivo_contratacion]) ?></td>
        <td width="160"><strong>CUCE:</strong></td>
        <td width="90"><?php echo utf8_encode($procedimiento[cuce]) ?></td>
    </tr>
</table>
<br>
<table align="center" width="600" class="tabla_informe">
    <tr class="cabecera-tabla">
        <td width="10" align="center"> <strong class="letra_9">Nro </strong></td>
        <td width="60" align="center"> <strong class="letra_9">Cantidad </strong></td>
        <td width="60" align="center"> <strong class="letra_9">Unidad </strong></td>
        <td width="360" align="center"> <strong class="letra_9">Descripcion </strong></td>
        <!-- <td width="140" align="center"> <strong class="letra_9">Partida <br> Presupuestaria </strong></td> -->
        <td width="65" align="center"> <strong class="letra_9">Precio Unitario <br>(BS.) </strong></td>
        <td width="65" align="center"> <strong class="letra_9">Precio Total <br>(BS.) </strong></td>
    </tr>
    <?php
    $total = 0;
    while ($registro_s = $bd->getFila($datos_requisitos)) {
        $n++; 
        $precio_unitario = number_format($registro_s[precio_unitario], 2, ',', '.');
        $precio_total = number_format($registro_s[precio_total], 2, ',', '.');
        $cantidad = floatval($registro_s[cantidad_solicitada]) ? intval($registro_s[cantidad_solicitada]) : $registro_s[cantidad_solicitada];
        
        ?>
        <tr>
            <td width="10" class="letra_9" align="center"> <?php echo utf8_encode($n) ?></td>
            <td width="60" class="letra_9" align="center"> <?php echo $cantidad; ?></td>
            <td width="60" class="letra_9" align="center"> <?php echo utf8_encode($registro_s[unidad_medida]) ?></td>
            <td width="360" class="letra_9"> <strong><?php echo " " . utf8_encode($registro_s[descripcion]) ?> </strong><br>
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
            <!-- <td width="140" class="letra_9 salto-texto" align="center"> <?php // echo utf8_encode($registro_s[nombre_partida]) ?></td> -->
            <td width="65" class="letra_9" align="right"> <?php echo $precio_unitario; ?></td>
            <td width="65" class="letra_9" align="right"> <?php echo $precio_total; ?></td>
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
<?php if (strlen($aclaracion) > 0) { ?>
    <p>
        <strong>Condiciones Adicionales y/o Aclaraciones</strong> <?php echo $aclaracion ?>
    </p>
<?php } ?>
<p>
    Verificando el cumplimiento de las especificaciones técnicas, de acuerdo a Contrato/Orden de Compra
    procedo a emitir mi <strong>CONFORMIDAD </strong> del Bien.
</p>
<p>
    En constancia de la misma firman al pie de la presente
</p>
<br><br><br><br>
<p align="center">
    <strong>RESPONSABLE O COMISIÓN DE RECEPCIÓN</strong> <br>
    <strong>RECIBI CONFORME</strong>
</p>

<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Acta_de_Recepcion_Solicitud_".$id_solicitud."_tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>