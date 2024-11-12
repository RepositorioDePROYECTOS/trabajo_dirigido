<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/fondo_empleados.php");
    setlocale(LC_TIME,"es_ES");

    $fondo_empleados = new fondo_empleados();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


    $registros = $bd->Consulta("select * from fondo_empleados fe inner join asignacion_cargo ac on fe.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where fe.mes=$mes and fe.gestion=$gestion order by cast(ac.item as unsigned) asc");

        
?>
<h1 align="center">PLANILLA DE FONDO DE EMPLEADOS</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Total ganado</td>
        <td>Porcentaje FE</td>
        <td>Monto aporte</td>
        <td>Pago deuda</td>
        <td>Total FE</td>
    </tr>

<?php
    $sum_t = 0;
    $sum_a = 0;
    $sum_d = 0;
    while($registro = $bd->getFila($registros))
    {
        
        echo "<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[total_ganado]</td><td>$registro[porcentaje_fe]%</td><td>$registro[monto_fe]</td><td>$registro[pago_deuda]</td><td>$registro[total_fe]</td></tr>";
        $sum_t = $sum_t + $registro[total_fe];
        $sum_a = $sum_a + $registro[monto_fe];
        $sum_d = $sum_d + $registro[pago_deuda];
    }

    echo "<tr><td colspan='4' align='center'>TOTAL</td><td>".round($sum_a,2)."</td><td>".round($sum_d,2)."</td><td>".round($sum_t,2)."</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_fondo_empleados.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>