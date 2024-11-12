<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../reportes/inicio_pagina_logo.php");

    $nombre_usuario = $_SESSION[nombre_completo];

    setlocale(LC_TIME,"es_ES");
    $id_solicitud_activo  = $_SESSION[id];

    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud_activo");
    $registro = $bd->getFila($registros_solicitud);

    $registros_s = $bd->Consulta("select * from detalle_activo where id_solicitud_activo=$id_solicitud_activo");

?>
<style>
    *{
        font-size: 9px;
    }
    .letra_9{
        font-size: 9px;
    }
    table{
        table-layout: fixed;
        width: 600px;
    }
    td.descripcion {
        width: 360px;
        word-wrap: break-word;
    }
</style>
<h1 align="center">activo DESPACHADOS 
<?php
    if($registro[existencia_activo]=='SI')
    echo " EN EXISTENCIA";
    else
    echo " SIN EXISTENCIA";
?>    
<br>Nro.
    <?php echo str_pad($registro[nro_solicitud_activo], 6, "0", STR_PAD_LEFT);?></h1>

    <table align="center" width="600" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="4" align="center"><strong>FORMULARIO DE activo DESPACHADOS</strong></td>
        </tr>
        <tr>
            <td width="120"><strong>ITEM:</strong></td>
            <td  width="230"><?php echo $registro[item_solicitante];?></td>
            <td width="160"><strong>FECHA SOLICITUD:</strong></td>
            <td  width="90"><?php echo date("d-m-Y", strtotime($registro[fecha_solicitud]));?></td>
        </tr>
        <tr>
            <td width="120"><strong>NOMBRE SOLICITANTE:</strong></td>
            <td width="230"><?php echo utf8_encode($registro[nombre_solicitante]);?></td>
            <td width="160"><strong>PROGRAMA:</strong></td>
            <td width="90"><?php echo $registro[programa_solicitud_activo];?></td>
        </tr>
        <tr>
            <td width="120"><strong>OFICINA SOLICITANTE:</strong></td>
            <td width="230"><?php echo $registro[oficina_solicitante];?></td>
            <td width="160"><strong>ACTIVIDAD:</strong></td>
            <td width="90"><?php echo $registro[actividad_solicitud_activo];?></td>
        </tr>
        <tr>
            <td width="120"><strong>JUSTIFICATIVO:</strong></td>
            <td width="480" colspan="3"><?php echo $registro[justificativo];?></td>
        </tr>

    </table>
    <table align="center" width="100%" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="6" align="center"><strong>DETALLE DE activo</strong></td>
        </tr>
        <tr>
            <td align="center" ><strong>Nro</strong></td>
            <td align="center" ><strong>Descripción</strong></td>
            <td align="center" ><strong>Unidad Medida</strong></td>
            <td align="center" ><strong>Cantidad Solicitada</strong></td>
            <td align="center" ><strong>Cantidad Despachada</strong></td>
        </tr>
        <?php
        $total=0;
        while($registro_s = $bd->getFila($registros_s)) 
        {
            $n++;
            $subtotal = $registro_s[cantidad_solicitada] * $registro_s[precio_unitario];
            echo "<tr>";        
            echo utf8_encode("
                    <td align='center'>$n</td>
                    <td class='descripcion'>$registro_s[descripcion]</td>
                    <td>$registro_s[unidad_medida]</td>
                    <td align='center'>$registro_s[cantidad_solicitada]</td>
                    <td align='right'>$registro_s[cantidad_despachada]</td>");
            echo "</tr>";
        }
        ?>

    </table>
    <table align="center"  width="600" class="tabla_reporte">
        <tr>
            <td width="205" align="center"><br><br><br><br><?php echo utf8_encode($registro[nombre_solicitante]);?><br><strong>FIRMA RECEPCION</strong></td>
            <td width="205" align="center"><br><br><br><br><?php echo utf8_encode($nombre_usuario);?><br><strong>DESPACHANTE</strong></td>
            <td width="205" align="center"><br><br><br><br><?php echo $registro[fecha_despacho];?><br><strong>FECHA DESPACHO</strong></td>
        </tr>
    </table>
<?php
        
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('papeleta_solicitud_activo.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id]);
?>