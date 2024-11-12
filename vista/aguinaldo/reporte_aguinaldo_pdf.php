<?php
    session_start();
    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo.php');
    
    setlocale(LC_TIME,"es_ES");
    
    
    include("../reportes/inicio_pagina_logo.php");
    include("../../modelo/aguinaldo.php");
    $aguinaldo = new aguinaldo();

    $gestion = $_SESSION[gestion];
    $nro_aguinaldo = $_SESSION[nro_aguinaldo];
?>
        <h1 align="center">PLANILLA DE PAGO</h1>
        <p align="left"><strong>NOMBRE:</strong>PLANILLA DE AGUINALDOS ELAPAS<br/>
        <strong>NRO AGUINALDO:</strong>PRIMER<br/>
        <strong>GESTION:</strong><?php echo $gestion;?><br/>
        <strong>NIT: 1016255025</strong><br/>
        <strong>Nro. PATRONAL: 060-521-006</strong></p>
<table class="tabla_reporte" align="center">
    <thead>
        <tr class="titulo">
            <td rowspan="2" width="20" height="30" align="center">ITEM</td>
            <td rowspan="2" width="50">CARNET IDENTIDAD</td>
            <td rowspan="2" width="130" align="center">NOMBRE EMPLEADO</td>
            <td rowspan="2" width="20" align="center">MESES</td>
            <td rowspan="2" width="20" align="center">DIAS</td>
            <td rowspan="2" width="20" align="center">SEXO</td>
            <td rowspan="2" width="100" align="center">CARGO QUE DESEMPENA</td>
            <td rowspan="2" width="40" align="center">FECHA DE INGRESO</td>
            <td colspan="3" width="90" align="center">TOTALES GANADO</td>
            <td rowspan="2" width="30" align="center">TOTAL</td>
            <td rowspan="2" width="30" align="center">PROMEDIO GANADO EN 3 MESES</td>
            <td rowspan="2" width="30"align="center">AGUINALDO ANUAL</td>
            <td rowspan="2" width="30" align="center">AGUINALDO A PAGAR</td>
            <td rowspan="2" width="150" align="center">FIRMA TRABAJADOR</td>               
        </tr>
        <tr class="titulo">
            <td width="30" align="center">SUELDO 1 SEPTIEMBRE</td>
            <td width="30" align="center">SUELDO 2 OCTUBRE</td>
            <td width="30" align="center">SUELDO 3 NOVIEMBRE</td>
        </tr>
    </thead>
    <tbody>
 
<?php

    $total_sueldo_1 = 0;
    $total_sueldo_2 = 0;
    $total_sueldo_3 = 0;
    $total_total = 0;
    $total_promedio_3_meses = 0;
    $total_aguinaldo_anual = 0;
    $total_aguinaldo_pagar = 0;
    $total_dias = 0;
   

    $registros_c = $bd->Consulta("select seccion from cargo where item<=200 group by seccion order by cast(item as unsigned) asc");
    
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='16' align='center'>SECCION $registro_c[0]</td></tr>";
        
        $total_sueldo_1_s = 0;
        $total_sueldo_2_s = 0;
        $total_sueldo_3_s = 0;
        $total_total_s = 0;
        $total_promedio_3_meses_s = 0;
        $total_aguinaldo_anual_s = 0;
        $total_aguinaldo_pagar_s = 0;
        $total_dias_s = 0;

        $registros_ac = $bd->Consulta("select * from cargo where seccion='$registro_c[seccion]' and item<=200 order by cast(item as unsigned) asc");

        while($registro_ac = $bd->getFila($registros_ac))
        {
            $registros_pl = $bd->Consulta("select * from aguinaldo where nro_aguinaldo=$nro_aguinaldo and gestion=$gestion and item=$registro_ac[item]");
            $registro_pl = $bd->getFila($registros_pl);

            if(!empty($registro_pl))
            {

                $registros = $bd->Consulta("select * from aguinaldo where nro_aguinaldo=$nro_aguinaldo and gestion=$gestion and item=$registro_ac[item] order by id_aguinaldo asc");
                $registro = $bd->getFila($registros);
                echo "<tr><td width='20' height='30'>$registro[item]</td><td width='50'>$registro[ci]</td><td width='130'>".utf8_encode($registro[nombre_empleado])."</td><td width='20'>$registro[meses]</td><td width='20'>$registro[dias]</td><td width='20'>$registro[sexo]</td><td width='100'>".utf8_encode($registro[cargo])."</td><td width='40'>$registro[fecha_ingreso]</td><td width='30'>$registro[sueldo_1]</td><td width='30'>$registro[sueldo_2]</td><td width='30'>$registro[sueldo_3]</td><td width='30'>$registro[total]</td><td width='30'>$registro[promedio_3_meses]</td><td width='30'>$registro[aguinaldo_anual]</td><td width='30'>$registro[aguinaldo_pagar]</td><td width='150' align='right'>$registro[item]</td></tr>";
               
                    $total_sueldo_1_s = $total_sueldo_1_s + $registro[sueldo_1];
                    $total_sueldo_2_s = $total_sueldo_2_s + $registro[sueldo_2];
                    $total_sueldo_3_s = $total_sueldo_3_s + $registro[sueldo_3];
                    $total_total_s = $total_total_s + $registro[total];
                    $total_promedio_3_meses_s = $total_promedio_3_meses_s + $registro[promedio_3_meses];
                    $total_aguinaldo_anual_s = $total_aguinaldo_anual_s + $registro[aguinaldo_anual];
                    $total_aguinaldo_pagar_s = $total_aguinaldo_pagar_s + $registro[aguinaldo_pagar];
                    $total_dias_s = $total_dias_s + $registro[dias];
                        
            }
            else
            {
                echo "<tr><td width='20'>".utf8_encode($registro_ac[1])."</td><td width='50'></td><td width='130'>ACEFALIA</td><td width='20'></td><td width='20'></td><td width='20'></td><td width='100'>".utf8_encode($registro_ac[descripcion])."</td><td width='40'></td><td width='30'>0.00</td><td width='30'>0.00</td><td width='30'>0.00</td><td width='30'>0.00</td><td width='30'>0.00</td><td width='30'>0.00</td><td width='30'>0.00</td><td width='150'></td></tr>";

            }
        }
        echo "<tr bgcolor='#d3ded5'><td colspan='4' align='center'>TOTAL SECCION</td><td align='right'>".number_format($total_dias_s,2)."</td><td align='right'></td><td align='right'></td><td align='right'></td><td align='right'>".number_format($total_sueldo_1_s,2)."</td><td align='right'>".number_format($total_sueldo_2_s,2)."</td><td align='right'>".number_format($total_sueldo_3_s,2)."</td><td align='right'>".number_format($total_total_s,2)."</td><td align='right'>".number_format($total_promedio_3_meses_s,2)."</td><td align='right'>".number_format($total_aguinaldo_anual_s,2)."</td><td align='right'>".number_format($total_aguinaldo_pagar_s,2)."</td><td width='150'></td></tr>";
        $total_sueldo_1 = $total_sueldo_1 + $total_sueldo_1_s;
        $total_sueldo_2 = $total_sueldo_2 + $total_sueldo_2_s;
        $total_sueldo_3 = $total_sueldo_3 + $total_sueldo_3_s;
        $total_total = $total_total + $total_total_s;
        $total_promedio_3_meses = $total_promedio_3_meses + $total_promedio_3_meses_s;
        $total_aguinaldo_anual = $total_aguinaldo_anual + $total_aguinaldo_anual_s;
        $total_aguinaldo_pagar = $total_aguinaldo_pagar + $total_aguinaldo_pagar_s;
        $total_dias = $total_dias + $total_dias_s;
        
    }
    echo "<tr><td colspan='4' align='center'>TOTAL GENERAL</td><td align='right'>".number_format($total_dias,2)."</td><td align='right'></td><td align='right'></td><td align='right'></td><td align='right'>".number_format($total_sueldo_1,2)."</td><td align='right'>".number_format($total_sueldo_2,2)."</td><td align='right'>".number_format($total_sueldo_3,2)."</td><td align='right'>".number_format($total_total,2)."</td><td align='right'>".number_format($total_promedio_3_meses,2)."</td><td align='right'>".number_format($total_aguinaldo_anual,2)."</td><td align='right'>".number_format($total_aguinaldo_pagar,2)."</td><td width='150'></td></tr>";
?>
</tbody>
</table>
<br><br><br><br>
<table align="center">
    <tr>
        <td align="center">Lic. Roberto Carlos Aguilar Rodriguez<br>JEFE ADMINISTRATIVO Y PERSONAL a.i.</td><td width="20"></td><td align="center">Lic. Elizabeth Zulema Brito Pozo<br>JEFE FINANCIERO Y CONTABLE</td><td width="20"></td><td align="center">Lic. Ernesto Sejas<br>GERENTE ADMINISTRATIVO Y FINANCIERO</td><td width="20"></td><td align="center">Ing. Grover Urquizo Paco<br> GERENTE GENERAL</td>
    </tr>
</table>
<?php

    echo "</page>";

    $content = ob_get_clean();

    try{
        $html2pdf = new HTML2PDF('L', 'Legal', 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("planilla_aguinaldo.pdf");
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>