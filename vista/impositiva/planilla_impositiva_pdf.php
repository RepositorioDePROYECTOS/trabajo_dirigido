<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/impositiva.php");
    setlocale(LC_TIME,"es_ES");

    $impositiva = new impositiva();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


           
?>
<h1 align="center">PLANILLA IMPOSITIVA</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td rowspan="2">Item</td>
        <td rowspan="2">Trabajador</td>
        <td rowspan="2">Total Ganado</td>
        <td rowspan="2">Aportes</td>
        <td rowspan="2">Refrigerio</td>
        <td rowspan="2">Sueldo neto</td>
        <td rowspan="2" width="30">Min. no imponible</td>
        <td rowspan="2" width="30">Base imponible</td>
        <td rowspan="2">Imp. B.I.</td>
        <td rowspan="2">Form 110(13%)</td>
        <td rowspan="2">13% S.M.</td>
        <td colspan="2">Saldo a favor</td>
        <td colspan="3">Saldo anterior a favor dependiente</td>
        <td rowspan="2" width="30">Saldo total Dep.</td>
        <td rowspan="2">Saldo utilizado</td>
        <td rowspan="2">Retencion</td>
        <td rowspan="2">Saldo Dep. Sig. mes</td>
    </tr>
    <tr class="titulo">
        <td>Fisco</td>
        <td>Dependiente</td>
        <td>Mes anterior</td>
        <td>Actualizacion</td>
        <td>Total</td>
    </tr>

<?php
    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum = 0;
    $sum_r = 0;
    $sum_rciva = 0;
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='20' align='center'>SECCION $registro_c[0]</td></tr>";
        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc");
        $sum_s = 0;
        $sum_r_s = 0;
        $sum_rciva_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {

                $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join impositiva i on i.id_asignacion_cargo=ac.id_asignacion_cargo inner join cargo c on c.id_cargo=ac.id_cargo inner join refrigerio r on r.id_asignacion_cargo=ac.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and i.mes=$mes and i.gestion=$gestion and r.mes=$mes and r.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned)asc ");
                $registro = $bd->getFila($registros);
                echo "<tr>";
                echo "<td>$registro[item]</td><td>$registro[apellido_paterno]$registro[apellido_materno]$registro[nombres]</td><td>$registro[total_ganado]</td><td>$registro[aportes_laborales]</td><td>$registro[total_refrigerio]</td><td>$registro[sueldo_neto]</td><td width='30'>$registro[minimo_no_imponible]</td><td width='30'>$registro[base_imponible]</td><td>$registro[impuesto_bi]</td><td>$registro[presentacion_desc]</td><td>$registro[impuesto_mn]</td><td>$registro[saldo_fisco]</td><td>$registro[saldo_dependiente]</td><td>$registro[saldo_mes_anterior]</td><td>$registro[actualizacion]</td><td>$registro[saldo_total_mes_anterior]</td><td width='30'>$registro[saldo_total_dependiente]</td><td>$registro[saldo_utilizado]</td><td>$registro[retencion_pagar]</td><td>$registro[saldo_siguiente_mes]</td>";
                    echo "</tr>";
                    $sum_s = $sum_s + $registro[saldo_siguiente_mes];
                    $sum_r_s = $sum_r_s + $registro[retencion_pagar];
                    $sum_rciva_s = $sum_rciva_s + $registro[presentacion_desc];
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='19' align='center'>ACEFALIA</td></tr>";
            }
        }
        echo "<tr><td colspan='19' align='center'>TOTAL SECCION $registro_c[0]</td><td>$sum_s</td></tr>";
            $sum = $sum + $sum_s;
            $sum_r = $sum_r + $sum_r_s;
            $sum_rciva = $sum_rciva + $sum_rciva_s;
    }

    echo "<tr><td colspan='9' align='center'>TOTAL DEL MES</td><td>".number_format($sum_rciva)."</td><td colspan='8'></td><td>".number_format($sum_r)."</td><td>".number_format($sum)."</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('L', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_impositiva.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>