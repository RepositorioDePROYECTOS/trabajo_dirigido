<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/suplencia.php");
    setlocale(LC_TIME,"es_ES");

    $suplencia = new suplencia();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


    $registros = $bd->Consulta("select sum(s.monto) as total, s.id_asignacion_cargo, t.apellido_paterno, t.apellido_materno, t.nombres, ac.item, s.salario_mensual, s.cargo_suplencia, s.total_dias from suplencia s inner join asignacion_cargo ac on s.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where mes=$mes and gestion=$gestion group by s.id_asignacion_cargo, t.apellido_paterno, t.apellido_materno, t.nombres, ac.item, s.salario_mensual, s.cargo_suplencia, s.total_dias");

        
?>
<h1 align="center">PLANILLA DE SUPLENCIAS</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Cargo Suplencia</td>
        <td>Salario Suplencia</td>
        <td>Dias suplencia</td>
        <td>Monto Suplencia</td>
    </tr>

<?php
    $sum = 0;
    while($registro = $bd->getFila($registros))
    {
        
        echo "<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[cargo_suplencia]</td><td align='right'>$registro[salario_mensual]</td><td align='center'>$registro[total_dias]</td><td align='right'>$registro[total]</td></tr>";
        $sum = $sum + $registro[total];
    }

    echo "<tr><td colspan='5' align='center'>TOTAL</td><td align='right'>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_suplencias.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>