<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/horas_extra.php");
    
    setlocale(LC_TIME,"es_ES");

    $horas_extra = new horas_extra();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];
    $registros = $bd->Consulta("select sum(he.monto) as total, sum(he.cantidad) as cantidad, he.id_asignacion_cargo, t.apellido_paterno, t.apellido_materno, t.nombres, ac.item, ac.salario, ac.cargo from horas_extra he inner join asignacion_cargo ac on he.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where he.mes=$mes and he.gestion=$gestion and ac.estado_asignacion='HABILITADO' group by he.id_asignacion_cargo, t.apellido_paterno, t.apellido_materno, t.nombres, ac.item, ac.salario, ac.cargo order by cast(ac.item as unsigned) asc");   
?>
<h1 align="center">PLANILLA DE HORAS EXTRA</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Cargo</td>
        <td>Salario</td>
        <td>Horas Ext.</td>
        <td>Monto Hrs Ext.</td>
    </tr>

<?php

    $sum = 0;
    $sum_h = 0;
    while($registro = $bd->getFila($registros))
    {
        
        echo "<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[cargo]</td><td>$registro[salario]</td><td>$registro[cantidad]</td><td>$registro[total]</td></tr>";
        $sum = $sum + $registro[total];
        $sum_h = $sum_h + $registro[cantidad];
    }

    echo "<tr><td colspan='4' align='center'>TOTAL</td><td>$sum_h</td><td>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_horas_extra.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
    unset($_SESSION[gestion]);
?>