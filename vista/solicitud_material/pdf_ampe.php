<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../reportes/inicio_pagina_logo.php");


    setlocale(LC_TIME,"es_ES");
    //$id_solicitud_material  = $_SESSION[id];
    $id_solicitud_material  = $_GET[id];

    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud_material");
    $registro = $bd->getFila($registros_solicitud);

    $registros_s = $bd->Consulta("select * from detalle_material where id_solicitud_material=$id_solicitud_material");

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
        width: 392px;
        word-wrap: break-word;
    }
</style>
<h1 align="center">SOLICITUD DE MATERIALES ANPE
<?php
    if($registro[existencia_material]=='SI')
    echo " EN EXISTENCIA";
    else
    echo " SIN EXISTENCIA";
?>    
<br>Nro.
    <?php echo str_pad($registro[nro_solicitud_material], 6, "0", STR_PAD_LEFT);?></h1>

    <table align="center" width="600" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="4" align="center"><strong>PAPELETA SOLICITUD DE MATERIALES</strong></td>
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
            <td width="90"><?php echo $registro[programa_solicitud_material];?></td>
        </tr>
        <tr>
            <td width="120"><strong>OFICINA SOLICITANTE:</strong></td>
            <td width="230"><?php echo utf8_decode($registro[oficina_solicitante]);?></td>
            <td width="160"><strong>ACTIVIDAD:</strong></td>
            <td width="90"><?php echo $registro[actividad_solicitud_material];?></td>
        </tr>
        <tr>
            <td width="120"><strong>JUSTIFICATIVO:</strong></td>
            <td width="480" colspan="3"><?php echo utf8_encode($registro[justificativo]);?></td>
        </tr>
    </table>
    <table align="center" width="100%" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="6" align="center"><strong>DETALLE DE MATERIALES</strong></td>
        </tr>
        <tr >
            <td align="center" ><strong class="letra_9">Nro</strong></td>
            <td align="center" ><strong class="letra_9">Descripción</strong></td>
            <td align="center" ><strong class="letra_9">Unidad Medida</strong></td>
            <td align="center" ><strong class="letra_9">Cantidad</strong></td>
            <td align="center" ><strong class="letra_9">Precio Unitario</strong></td>
            <td align="center" ><strong class="letra_9">Subtotal</strong></td>
        </tr>
        <?php
        $total=0;
        while($registro_s = $bd->getFila($registros_s)) 
        {
            $n++;
            $subtotal = $registro_s[cantidad_solicitada] * $registro_s[precio_unitario];
            echo "<tr>";        
            echo utf8_encode("
                    <td class='letra_9' align='center'>$n</td>
                    <td class='letra_9 descripcion'>$registro_s[descripcion]</td>
                    <td class='letra_9'>$registro_s[unidad_medida]</td>
                    <td class='letra_9' align='center'>$registro_s[cantidad_solicitada]</td>
                    <td class='letra_9' align='right'>$registro_s[precio_unitario]</td>
                    <td class='letra_9' align='right'>$subtotal</td>"
                );
            echo "</tr>";
            $total = $total + $subtotal;
        }
        ?>
        <tr>
            <td colspan="5" align="right"><strong>TOTAL</strong></td>
            <td align="right"><?php echo $total; ?></td>
        </tr>
    </table>
    <table align="center"  width="600" class="tabla_reporte">
        <tr>
            <td width="150" height="80" align="center"><br><br><br><br><br><br><?php echo utf8_encode($registro[nombre_solicitante]);?><br><strong>FIRMA SOLICITANTE</strong></td>
            <td width="150" height="80" align="center"><br><br><br><br><br><br><?php echo utf8_encode($registro[autorizado_por]);?><br><strong>AUTORIZADO
                    POR</strong></td>
            <td width="150" height="80" align="center"><br><br><br><br><br><br><?php echo utf8_encode($registro[gerente_area]);?><br><strong>GERENTE AREA</strong></td>        
            <td width="150" height="80" align="center"><br><br><br><br><br><br><?php echo utf8_encode($registro[visto_bueno]);?><br><strong>VISTO BUENO</strong></td>
        </tr>
    </table>
    <?php
    if($registro[existencia_material]=='NO')
    {
    ?>
    <table align="center"  width="600" class="tabla_reporte">
        <tr>
            <td width="205" height="100" align="left"><br><br><br><br><br><br><br><strong>Fecha:__/__/____</strong><br><br><strong>SIN EXISTENCIA</strong></td>
            <td width="205" height="100" align="left"><br><br><br><br><br><br><br><strong>Fecha:__/__/____</strong><br><br><strong>PRESUPUESTADO</strong></td>
            <td width="205" height="100" align="left"><br><br><br><br><br><br><br><strong>Fecha:__/__/____</strong><br><br><strong>INICIO ADQUISICION</strong></td>
        </tr>
    </table>

<?php
     }
        
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('papeleta_solicitud_material.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id]);
?>