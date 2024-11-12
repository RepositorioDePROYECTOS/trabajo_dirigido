<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/descargo_refrigerio.php");
    setlocale(LC_TIME,"es_ES");

    $descargo_refrigerio = new descargo_refrigerio();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];

           
?>
<h1 align="center">PLANILLA DESCARGO REFRIGERIO</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo" height="20">
        <td>Item</td>
        <td width="100">Cargo</td>
        <td width="100">Trabajador</td>
        <td width="40">Dias laborables</td>
        <td width="40">Dias trabajados</td>
        <td width="40">Monto Refrigerio</td>
        <td width="40">Monto descargo</td>
        <td width="40">Retencion</td>
        <td width="40">Total Refrigerio</td>
        <td width="100">FIRMA</td>
    </tr>

<?php
    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum_td = 0;
    $sum_mr = 0;
    $sum_md = 0;
    $sum_r = 0;
    $sum_tr = 0;
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='10' align='center'>SECCION $registro_c[0]</td></tr>";

        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc"); 
        $sum_td_s = 0;
        $sum_mr_s = 0;
        $sum_md_s = 0;
        $sum_r_s = 0;
        $sum_tr_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {
                $registros = $bd->Consulta("select * from cargo c right join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join asistencia_refrigerio a on a.id_asignacion_cargo=ac.id_asignacion_cargo inner join descargo_refrigerio d on a.id_asistencia_refrigerio=d.id_asistencia_refrigerio where d.mes=$mes and d.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc");
                
                $registro = $bd->getFila($registros);
                    
                echo "<tr><td height='15'>$registro_ac[item]</td><td width='100'>$registro_ac[descripcion]</td><td width='100'>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td  width='40'>$registro[dias_laborables]</td><td width='40'>$registro[dias_asistencia]</td><td width='40'>$registro[monto_refrigerio]</td><td>$registro[monto_descargo]</td><td>$registro[retencion]</td><td>$registro[total_refrigerio]</td><td></td></tr>";
                $sum_td_s = $sum_td_s + $registro[dias_asistencia];
                $sum_mr_s = round($sum_mr_s + $registro[monto_refrigerio],2);
                $sum_md_s = round($sum_md_s + $registro[monto_descargo],2);
                $sum_r_s = round($sum_r_s + $registro[retencion],2);
                $sum_tr_s = round($sum_tr_s + $registro[total_refrigerio],2);
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='9' align='center'>ACEFALIA</td></tr>";
            }
                 
            
        }
        echo "<tr><td colspan='4' align='center'>SECCION $registro_c[0]</td><td align='center'>$sum_td_s</td><td align='right'>".number_format($sum_mr_s,2)."</td><td align='right'>".number_format($sum_md_s,2)."</td><td align='right'>".number_format($sum_r_s,2)."</td><td align='right'>".number_format($sum_tr_s,2)."</td><td></td></tr>";
        $sum_td = $sum_td + $sum_td_s;
        $sum_mr = $sum_mr + $sum_mr_s;
        $sum_md = $sum_md + $sum_md_s;
        $sum_r = $sum_r + $sum_r_s;
        $sum_tr = $sum_tr + $sum_tr_s;
         
        
    }
    echo "<tr><td colspan='4' align='center'>TOTALES</td><td align='center'>$sum_td</td><td align='right'>".number_format($sum_mr,2)."</td><td align='right'>".number_format($sum_md,2)."</td><td align='right'>".number_format($sum_r,2)."</td><td align='right'>".number_format($sum_tr,2)."</td><td></td></tr>";   
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_descargo_refrigerio.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>