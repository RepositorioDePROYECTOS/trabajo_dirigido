<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/otros_descuentos.php");
    setlocale(LC_TIME,"es_ES");

    $otros_descuentos = new otros_descuentos();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


           
?>
<h1 align="center">PLANILLA OTROS DESCUENTOS</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Sindicalizado</td>
        <td>Haber basico</td>
        <td>Total Ganado</td>
        <td>Descripcion</td>
        <td>Monto Desc.</td>
    </tr>

<?php
    $verificars = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion");
    $verificar = $bd->getFila($verificars);
    if(empty($verificar))
    {
        $registros = $bd->Consulta("select ac.item, d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, ac.sindicato, ac.salario as haber_basico, ac.salario as total_ganado, d.descripcion, d.monto_od from otros_descuentos d inner join asignacion_cargo ac on d.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where d.mes=$mes and d.gestion=$gestion  group by ac.item, d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, ac.sindicato, haber_basico, total_ganado, d.descripcion, d.monto_od order by cast(ac.item as unsigned) asc");
    }
    else
    {
        $registros = $bd->Consulta("select ac.item, d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, ac.sindicato, tg.haber_basico, tg.total_ganado, d.descripcion, d.monto_od from otros_descuentos d inner join asignacion_cargo ac on d.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join total_ganado tg on ac.id_asignacion_cargo=tg.id_asignacion_cargo where d.mes=$mes and d.gestion=$gestion and tg.mes=$mes and tg.gestion=$gestion group by ac.item, d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, ac.sindicato, tg.haber_basico, tg.total_ganado, d.descripcion, d.monto_od order by cast(ac.item as unsigned) asc");
    }
    
    $sum = 0;
    while($registro = $bd->getFila($registros))
    {
        echo utf8_encode("<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td>");
        if($registro[sindicato] == 1)
        {
            echo utf8_encode("<td>SI</td>");
        }
        else
        {
            echo utf8_encode("<td>NO</td>");
        }

        echo utf8_encode("<td>$registro[haber_basico]</td><td>$registro[total_ganado]</td><td>$registro[descripcion]</td><td>$registro[monto_od]</td></tr>");
        $sum = $sum + $registro[monto_od];
    }

    echo "<tr><td colspan='6' align='center'>TOTAL</td><td>".number_format($sum,2)."</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_otros_descuentos.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>