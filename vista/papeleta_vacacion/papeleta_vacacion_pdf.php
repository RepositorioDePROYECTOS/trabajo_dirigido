<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../reportes/inicio_pagina_logo.php");
    include("../../modelo/papeleta_vacacion.php");
    setlocale(LC_TIME,"es_ES");

    $papeleta_vacacion = new papeleta_vacacion();
    $id_papeleta_vacacion  = $_SESSION[id];
    $papeleta_vacacion->get_papeleta_vacacion($id_papeleta_vacacion);

    $registros = $bd->Consulta("SELECT * 
        from vacacion v 
        inner join trabajador t on v.id_trabajador=t.id_trabajador 
        inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador 
        inner join detalle_vacacion dv on v.id_vacacion=dv.id_vacacion 
        inner join papeleta_vacacion pv on pv.id_detalle_vacacion=dv.id_detalle_vacacion 
        inner join cargo c on c.id_cargo=ac.id_cargo where pv.id_papeleta_vacacion=$id_papeleta_vacacion");
    $registro = $bd->getFila($registros);

    $saldo = $registro[cantidad_dias] - $registro[dias_utilizados];
    $saldo_posible = ($registro[cantidad_dias] - $registro[dias_utilizados]) - $registro[dias_solicitados];

    $saldo_actual = floatval($registro[saldo_dias]) ? $registro[saldo_dias] : intval($registro[saldo_dias]);
    $saldo_vacacion = floatval($registro[saldo_dias] - $registro[dias_solicitados]) ? ($registro[saldo_dias] - $registro[dias_solicitados]) : intval($registro[saldo_dias] - $registro[dias_solicitados]) ;
    $dias_solicitados = floatval($registro[dias_solicitados]) ?  $registro[dias_solicitados] : intval($registro[dias_solicitados]);
              
?>
<h1 align="center">SOLICITUD DE VACACIONES <br>Nro.<?php echo $registro[id_papeleta_vacacion];?> </h1>

<table align="center" width="600" class="tabla_reporte">
    <tr class="titulo">
        <td colspan="2" width="350" align="center"><strong>PAPELETA SOLICITUD DE VACACIONES</strong></td>
        <td colspan="2" width="250" align="center"><strong>Correspondiente gestion:</strong> <?php echo $registro[gestion_inicio]." al ".$registro[gestion_fin];?></td>
    </tr>
    <tr>
        <td width="120"><strong>ITEM:</strong></td><td width="230"><?php echo $registro[item];?></td>
        <td width="160"><strong>FECHA SOLICITUD:</strong></td><td width="90"><?php echo $registro[fecha_solicitud];?></td>
    </tr>
    <tr>
        <td><strong>NOMBRE:</strong></td><td><?php echo $registro[nombres]." ".$registro[apellido_paterno]." ".$registro[apellido_materno];?></td>
        <td><strong>SALDO ACTUAL:</strong></td><td><?php echo $saldo_actual;?></td>
    </tr>
    <tr>
        <td><strong>SECCION:</strong></td><td><?php echo $registro[seccion];?></td>
        <td><strong>CARGO:</strong></td><td><?php echo $registro[cargo];?></td>
    </tr>
    
    <tr class="titulo">
        <td colspan="4" align="center"><strong>DATOS DE VACACION SOLICITADA</strong></td>
    </tr>
    <tr>
        <td><strong>Fecha Inicio:</strong></td><td><?php echo $registro[fecha_inicio];?></td>
        <td><strong>Fecha Conclusi&oacute;n:</strong></td><td><?php echo $registro[fecha_fin];?></td>
    </tr>
    <tr>
        <td><strong>D&iacute;as solicitados:</strong></td><td><?php echo  $dias_solicitados;?></td>
        <td><strong>Saldo vacaci&oacute;n:</strong></td><td><?php echo  $saldo_vacacion;?></td>
    </tr>
    <tr>
        <td valign="top"><strong>Observaci&oacute;n:</strong></td>
        <td colspan="3" height="90" width="480" valign="top"><?php echo $registro[observacion];?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><br><br><br><br><br><?php echo $registro[autorizado_por];?><br><strong>AUTORIZADO POR</strong></td>
        <td colspan="2" align="center"><br><br><br><br><br><br><strong>FIRMA SOLICITANTE</strong></td>
    </tr>
</table>
<?php
        
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9,279.4), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('papeleta_vacacion.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id]);
?>