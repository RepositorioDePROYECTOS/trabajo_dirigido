<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/total_ganado.php");
    setlocale(LC_TIME,"es_ES");

    $total_ganado = new total_ganado();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


           
?>
<h1 align="center">PLANILLA DE TOTAL GANADO</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Cargo</td>
        <td>Total dias</td>
        <td>Haber mensual</td>
        <td>Haber basico</td>
        <td>Bono antiguedad</td>
        <td>Horas extra</td>
        <td>Monto hrs extra</td>
        <td>Suplencia</td>
        <td>Total ganado</td>
    </tr>

<?php

    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum = 0;
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='11' align='center'>SECCION $registro_c[0]</td></tr>";
        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc");
        $sum_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {
                $registros = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on ac.id_trabajador=t.id_trabajador inner join cargo c on c.id_cargo=ac.id_cargo where ac.estado_asignacion='HABILITADO' and tg.mes=$mes and tg.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc ");

                $registro = $bd->getFila($registros);
                
                    echo "<tr>";
                    echo utf8_encode("<td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[cargo]</td><td>$registro[total_dias]</td><td>$registro[haber_mensual]</td><td>$registro[haber_basico]</td><td>$registro[bono_antiguedad]</td><td>$registro[nro_horas_extra]</td><td>$registro[monto_horas_extra]</td><td>$registro[suplencia]</td><td>$registro[total_ganado]</td>");
                    echo "</tr>";
                    $sum_s = $sum_s + $registro[total_ganado];
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='10' align='center'>ACEFALIA</td></tr>";
            } 
        } 

        echo "<tr><td colspan='10' align='center'>TOTAL SECCION $registro_c[0]</td><td>$sum_s</td></tr>";
            $sum = $sum + $sum_s;
    }
            
    echo "<tr><td colspan='10' align='center'>TOTAL GANADO DEL MES</td><td>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('L', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_total_ganado.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>