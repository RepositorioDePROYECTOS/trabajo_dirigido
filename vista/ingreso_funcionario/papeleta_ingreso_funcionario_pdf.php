<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../reportes/inicio_pagina_logo.php");
    include("../../modelo/ingreso_funcionario.php");
    setlocale(LC_TIME,"es_ES");

    $ingreso_funcionario = new ingreso_funcionario();
    $id_ingreso_funcionario  = $_SESSION[id];
    $ingreso_funcionario->get_ingreso_funcionario($id_ingreso_funcionario);

    $registros = $bd->Consulta("select * from ingreso_funcionario i inner join usuario u on i.id_usuario=u.id_usuario inner join trabajador t on u.id_trabajador=t.id_trabajador inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where i.id_ingreso_funcionario=$id_ingreso_funcionario");
    $registro = $bd->getFila($registros);

    $registros_t = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where t.id_trabajador=$registro[autorizado_por]");
    $registro_t = $bd->getFila($registros_t);
              
?>
<h1 align="center">SOLICITUD DE INGRESO A OFICINAS DE ELAPAS</h1>

<table align="center" width="600" class="tabla_reporte">
    <tr class="titulo">
        <td colspan="4" width="350" align="center"><strong>PAPELETA SOLICITUD DE INGRESO</strong></td>
    </tr>
    <tr>
        <td width="120"><strong>ITEM:</strong></td><td width="230"><?php echo $registro[item];?></td><td width="160"><strong>Nro. SOLICITUD:</strong></td><td width="90"><?php echo $registro[id_ingreso_funcionario];?></td>
    </tr>
    <tr>
        <td><strong>NOMBRE:</strong></td><td><?php echo $registro[nombres]." ".$registro[apellido_paterno]." ".$registro[apellido_materno];?></td><td><strong>FECHA SOLICITUD:</strong></td><td><?php echo $registro[fecha_registro];?></td>
    </tr>
    <tr>
        <td><strong>SECCION:</strong></td><td><?php echo $registro[seccion];?></td><td><strong>CARGO:</strong></td><td><?php echo $registro[cargo];?></td>
    </tr>
    
    <tr class="titulo">
        <td colspan="4" align="center"><strong>DATOS DE SOLICITUD DE INGRESO A OFICINAS DE ELAPAS</strong></td>
    </tr>
    <tr>
        <td><strong>Fecha de ingreso:</strong></td><td><?php echo $registro[fecha_ingreso];?></td><td><strong>De horas:</strong></td><td><?php echo $registro[hora_inicio]." a horas: ".$registro[hora_fin];?></td>
    </tr>
    
    <tr>
        <td><strong>Motivo ingreso:</strong></td><td><?php echo $registro[motivo_ingreso];?></td>
        <td valign="top"><strong>Observaci&oacute;n:</strong></td><td colspan="3" height="80" valign="top"><?php echo $registro[observacion];?></td>
    </tr>
    <tr>
        <td align="center"><br><br><br><br><br><br><strong>FIRMA SOLICITANTE</strong></td>
        <td colspan="2" align="center"><br><br><br><br><br><?php echo $registro_t[nombres]." ".$registro_t[apellido_paterno]." ".$registro_t[apellido_materno];?><br><strong>AUTORIZADO POR</strong></td>
        <td align="center"><br><br><br><br><br><strong>JEFE ADMINISTRATIVO Y RRHH</strong>
            
        </td>
    </tr>
</table>
<?php
        
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('L', array(139.7,215.9), 'es', true, 'UTF-8', array(10, 0, 10, 0));
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