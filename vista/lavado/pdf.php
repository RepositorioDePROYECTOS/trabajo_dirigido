<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../reportes/inicio_pagina_logo.php");


    setlocale(LC_TIME,"es_ES");
    //$id_solicitud_activo  = $_SESSION[id];
    $id_lavado  = $_GET[id];

    $registros_solicitud = $bd->Consulta("SELECT * FROM lavado l inner join usuario u on l.id_usuario=u.id_usuario inner join trabajador t on u.id_trabajador=t.id_trabajador inner join asignacion_cargo ac on ac.id_trabajador=t.id_trabajador WHERE l.id_lavado=$id_lavado");
    $registro = $bd->getFila($registros_solicitud);

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
<h1 align="center">SOLICITUD DE LAVADO DE VEHICULO
 
<br>Nro.
    <?php echo str_pad($registro[id_lavado], 6, "0", STR_PAD_LEFT);?></h1>

    <table align="center" width="600" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="4" align="center"><strong>PAPELETA SOLICITUD DE LAVADO DE VEHICULO</strong></td>
        </tr>
        <tr>
            <td width="120"><strong>ITEM:</strong></td>
            <td  width="230"><?php echo $registro[item];?></td>
            <td width="160"><strong>FECHA SOLICITUD:</strong></td>
            <td  width="90"><?php echo date("d-m-Y", strtotime($registro[fecha_solicitud]));?></td>
        </tr>
        <tr>
            <td width="120"><strong>NOMBRE SOLICITANTE:</strong></td>
            <td width="230"><?php echo utf8_encode($registro[nombres].' '.$registro[apellido_paterno].' '.$registro[apellido_materno]);?></td>
            <td width="160"><strong>CARGO:</strong></td>
            <td width="90"><?php echo $registro[cargo];?></td>
        </tr>
        <tr>
            <td width="120"><strong>JEFATURA:</strong></td>
            <td width="230"><?php echo utf8_encode($registro[jefatura]);?></td>
            <td width="160"><strong>GERENCIA:</strong></td>
            <td width="90"><?php echo $registro[gerencia];?></td>
        </tr>
    </table>
    <table align="center" width="600" class="tabla_reporte">
        <tr class="titulo">
            <td colspan="4" align="center" width='600'><strong>DETALLE DEL LAVADO</strong></td>
        </tr>
        <tr >
            <td align="center" width="50"><strong class="letra_9">Nro</strong></td>
            <td align="center" width="250"><strong class="letra_9">VEHICULO</strong></td>
            <td align="center" width="150"><strong class="letra_9">TIPO</strong></td>
            <td align="center" width="150"><strong class="letra_9">PLACA</strong></td>
        </tr>
        <?php
            echo "<tr>";        
            echo utf8_encode("
                    <td align='center' width='50'>1</td>
                    <td width='250' align='center'>$registro[marca_vehiculo]</td>
                    <td width='150' align='center'>$registro[tipo_vehiculo]</td>
                    <td align='center' width='150'>$registro[numero_placa]</td>"
                );
            echo "</tr>";
        ?>
    </table>
    <table align="center"  width="600" class="tabla_reporte">
        <tr>
            <td height="80" width="205" align="center"><br><br><br><br><br><br><?php echo utf8_encode($registro[nombres].' '.$registro[apellido_paterno].' '.$registro[apellido_materno]);?><br><strong>FIRMA SOLICITANTE</strong></td>
            <td height="80" width="205" align="center"><br><br><br><br><br><br><strong>FIRMA JEFE/GERENTE DE AREA<br>APROBADO</strong></td>
            <td height="80" width="205" align="center"><br><br><br><br><br><br><strong>GERENTE ADMINISTRATIVO FINANCIERO<br>VISTO BUENO</strong></td>
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