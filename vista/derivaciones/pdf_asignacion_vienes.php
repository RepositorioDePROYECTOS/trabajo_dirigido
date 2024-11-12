<?php
session_start();
require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();
require_once('../reportes/cabeza_logo_papeleta.php');
include("../reportes/inicio_pagina_logo.php");
require_once('../reportes/numero_a_letras.php');
setlocale(LC_TIME, "es_ES");

$id_solicitud  = $_GET[id_solicitud];
$tipo          = $_GET[tipo];
$id_proveedor  = $_GET[id_proveedor];
$id_detalle    = $_GET[id_detalle];
$nro_factura   = $_GET[nro_factura];
$fecha_factura = $_GET[fecha_factura];
$observaciones = ($_GET[observaciones] != NULL) ? strtoupper($_GET[observaciones]) : '';
$buscar = $bd->Consulta("SELECT p.id_procedimientos 
    FROM requisitos as r 
    INNER JOIN procedimientos as p ON r.id_requisitos = p.id_requisitos
    WHERE r.id_solicitud = $id_solicitud AND r.id_proveedor = $id_proveedor;
");
while($b=$bd->getFila($buscar)){
    $insertar = $bd->Consulta("UPDATE procedimientos SET nro_factura='$nro_factura', fecha_factura='$fecha_factura' WHERE id_procedimientos=$b[id_procedimientos]");
}
// // $numero_de_orden = "";

// $derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud AND tipo_solicitud='$tipo'");
// $derivacion = $bd->getFila($derivaciones);
// // var_dump($derivacion);
// $procedimientos = $bd->Consulta("SELECT * FROM procedimientos WHERE id_requisitos=$id_requisitos AND id_derivacion=$derivacion[id_derivacion]");
// $procedimiento = $bd->getFila($procedimientos);

// $trab1 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[responsable]");
// $t1 = $bd->getFila($trab1);

// $trab2 = $bd->Consulta("SELECT * FROM trabajador WHERE id_trabajador =$procedimiento[designado]");
// $t2 = $bd->getFila($trab2);
if ($tipo == "material") {
    $solicitud=$bd->Consulta("SELECT c.descripcion, c.seccion , p.designado as trabajador_responsable, s.unidad_solicitante , p.tipo, pv.nombre, pv.nit, p.fecha_elaboracion, nro_solicitud_material as nro, p.nro_factura, p.fecha_factura,SUM(d.precio_unitario) as importe,SUM(d.precio_total) as total, par.nombre_partida 
        FROM solicitud_material as s
        INNER JOIN usuario as u ON u.id_usuario = s.id_usuario
        INNER JOIN trabajador as t ON t.id_trabajador = u.id_trabajador
        INNER JOIN asignacion_cargo as ac ON ac.id_trabajador = t.id_trabajador
        INNER JOIN cargo as c ON c.id_cargo = ac.id_cargo
        INNER JOIN detalle_material as d ON d.id_solicitud_material=s.id_solicitud_material
        INNER JOIN partidas as par ON par.id_partida = d.id_partida
        INNER JOIN requisitos as r ON r.id_solicitud=s.id_solicitud_material
        INNER JOIN procedimientos as p ON p.id_requisitos = r.id_requisitos
        INNER JOIN proveedores as pv ON pv.id_proveedor=r.id_proveedor
        WHERE s.id_solicitud_material=$id_solicitud AND r.id_proveedor=$id_proveedor
        GROUP BY r.id_proveedor;");
    $sol=$bd->getFila($solicitud);
} elseif($tipo == "activo") {
    $solicitud=$bd->Consulta("SELECT c.descripcion, c.seccion , p.designado as trabajador_responsable, s.unidad_solicitante , p.tipo,   pv.nombre, pv.nit, p.fecha_elaboracion, nro_solicitud_activo as nro, p.nro_factura, p.fecha_factura,SUM(d.precio_unitario) as importe,SUM(d.precio_total) as total, par.nombre_partida 
        FROM solicitud_activo as s
        INNER JOIN usuario as u ON u.id_usuario = s.id_usuario
        INNER JOIN trabajador as t ON t.id_trabajador = u.id_trabajador
        INNER JOIN asignacion_cargo as ac ON ac.id_trabajador = t.id_trabajador
        INNER JOIN cargo as c ON c.id_cargo = ac.id_cargo
        INNER JOIN detalle_activo as d ON d.id_solicitud_activo=s.id_solicitud_activo
        INNER JOIN partidas as par ON par.id_partida = d.id_partida
        INNER JOIN requisitos as r ON r.id_solicitud=s.id_solicitud_activo
        INNER JOIN procedimientos as p ON p.id_requisitos = r.id_requisitos
        INNER JOIN proveedores as pv ON pv.id_proveedor=r.id_proveedor
        WHERE s.id_solicitud_activo=$id_solicitud AND r.id_proveedor=$id_proveedor
        GROUP BY r.id_proveedor;");
    $sol=$bd->getFila($solicitud);
} else {
        $solicitud=$bd->Consulta("SELECT c.descripcion, c.seccion , p.designado as trabajador_responsable, s.unidad_solicitante , p.tipo, pv.nombre, pv.nit, p.fecha_elaboracion, nro_solicitud_servicio as nro, p.nro_factura, p.fecha_factura,SUM(d.precio_unitario) as importe,SUM(d.precio_total) as total, par.nombre_partida 
        FROM solicitud_servicio as s
        INNER JOIN usuario as u ON u.id_usuario = s.id_usuario
        INNER JOIN trabajador as t ON t.id_trabajador = u.id_trabajador
        INNER JOIN asignacion_cargo as ac ON ac.id_trabajador = t.id_trabajador
        INNER JOIN cargo as c ON c.id_cargo = ac.id_cargo
        INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio=s.id_solicitud_servicio
        INNER JOIN partidas as par ON par.id_partida = d.id_partida
        INNER JOIN requisitos as r ON r.id_solicitud=s.id_solicitud_servicio
        INNER JOIN procedimientos as p ON p.id_requisitos = r.id_requisitos
        INNER JOIN proveedores as pv ON pv.id_proveedor=r.id_proveedor
        WHERE s.id_solicitud_servicio=$id_solicitud AND r.id_proveedor=$id_proveedor
        GROUP BY r.id_proveedor;");
    $sol=$bd->getFila($solicitud);
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

    .break {
        page-break-after: always;
    }

    * {
        font-size: 9px;
    }

    .tamanio {
        font-size: 12px;
    }

    .tamanio1 {
        font-size: 13px;
    }

    table {
        table-layout: fixed;
        width: 600px;
    }

    p {
        font-size: 13px;
        font-weight: bold;
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
        FORMULARIO CM - 12
        <br>
        ACTA DE ASIGNACIÓN DE BIENES
    </h1>
</div>
<table align="center" width="690" border="0">
    <tr>
        <td width="690" align="left" class="tamanio" colspan="3">Lugar y Fecha:</td>
    </tr>
    <tr>
        <td width="690" align="left" class="tamanio" colspan="3">En Oficinas de Activos Fijos de ELAPAS se da conformidad al siguiente acta de asignacion de Bienes.</td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Código asignado:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo strtoupper($sol[tipo])." ".str_pad($sol[nro], 6, "0", STR_PAD_LEFT);?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Gerencia:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[seccion]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Jefatura:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[unidad_solicitante]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Nombre del trabajador receptor:</td>
        <td width="240" class="tamanio" colspan="2">
            <?php
                $trabajador = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador=$sol[trabajador_responsable]");
                $t = $bd->getFila($trabajador); 
                echo utf8_encode(strtoupper($t[nombres]))." ".utf8_encode(strtoupper($t[apellido_paterno]))." ".utf8_encode(strtoupper($t[apellido_materno]));
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Cargo:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[descripcion]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Registro SIAF:</td>
        <td width="240" class="tamanio" colspan="2"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Proveedor:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[nombre]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">No de factura:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[nro_factura]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Numero N I T:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[nit]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Fecha factura:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[fecha_factura]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Importe:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo number_format($sol[importe], 2, ',', '.');?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">TOTAL:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo number_format($sol[total], 2, ',', '.');?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Monto en Literal 00/100 Bolivianos.-</td>
        <td width="240" class="tamanio" colspan="2"><?php echo numeroALetras($sol[total]); ?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Partida Contable:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo utf8_encode(strtoupper($sol[nombre_partida]));?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="left" class="tamanio">Observaciones:</td>
        <td width="240" class="tamanio" colspan="2"><?php echo $observaciones;?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td width="170" align="center">
            <br><br><br><br><br><br><br><br>
            Responsable de la Recepcion <br> UNIDAD SOLICITANTE
        </td>
        <td width="170" align="center">
            <br><br><br><br><br><br><br><br>
            RESPONSABLE UNIDAD ACTIVOS FIJOS
            <br>
            VºBº
        </td>
        <td width="170" align="center">
            <br><br><br><br><br><br><br><br>
            AUXILIAR
            <br>
            ACTIVOS FIJOS
        </td>
    </tr>
</table>

<?php
echo "</page>";
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output("Asignacion_de_Vienes_Solicitud".$id_solicitud."_tipo_".$tipo.".pdf");
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

unset($_SESSION[id]);
?>