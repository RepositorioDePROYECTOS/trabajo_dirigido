<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/salida.php");
    setlocale(LC_TIME,"es_ES");

    $salida = new salida();
    $estado=$_SESSION[estado];
    $fecha_i  = $_SESSION[fecha_i];
    $fecha_f = $_SESSION[fecha_f];
    $fecha_inicio=strtotime($fecha_i);
    $fecha_fin=strtotime($fecha_f); 
?>
<h1 align="center">PLANILLA DE SALIDA</h1>
<h3 align="center">Periodo del : <strong> <?php echo date("d-M-Y",$fecha_inicio)."</strong> al <strong>".date("d-M-Y",$fecha_fin);?></strong></h3>
<table class="cont" align="center" cellspacing="0">
        <tr class="titulo">
			<td>No</td>
			<td>Fecha</td>
            <td>Hora salida</td>
            <td>Hora ret.</td>
            <td>Hora llegada ex.</td>
            <td>Direccion de Salida</td>
            <td>Motivo</td>
            <td>Observaciones</td>
            <td>Usuario</td>
		</tr>

<?php
    $n = 0;
    $registros = $bd->Consulta("SELECT * FROM salida s inner join usuario u on u.id_usuario=s.id_usuario inner join trabajador t on u.id_trabajador=t.id_trabajador where s.fecha between '$fecha_i' and '$fecha_f' and s.estado=$estado");
    while($registro = $bd->getFila($registros))
    {
        echo "<tr>";       
        echo utf8_encode("  <td>$n</td>
                            <td>$registro[fecha]</td>
                            <td>$registro[hora_salida]</td>
                            <td>$registro[hora_retorno]</td>
                            <td>$registro[hora_exac_llegada]</td>
                            <td>$registro[direccion_salida]</td>
                            <td>$registro[motivo]</td>
                            <td>$registro[observaciones]</td>
                            <td>$registro[23]</td>");
        echo "</tr>";
    }
   
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Planilla_salida.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>