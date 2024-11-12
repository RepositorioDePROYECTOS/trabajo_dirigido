<?php
    session_start();
    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza_logo.php');
    
    setlocale(LC_TIME,"es_ES");
    
    $id_nombre_planilla = $_SESSION[id];
    
    include("../reportes/inicio_pagina_logo.php");
    include("../../modelo/nombre_planilla.php");
    $nombre_planilla = new nombre_planilla();
    $nombre_planilla->get_nombre_planilla($id_nombre_planilla);
    
?>
        <h1 align="center">PLANILLA DE PAGO</h1>
        <p align="left"><strong>NOMBRE:</strong><?php echo $nombre_planilla->nombre_planilla;?><br/>
        <strong>MES:</strong><?php echo $nombre_planilla->mes;?><br/>
        <strong>GESTION:</strong><?php echo $nombre_planilla->gestion;?></p>
<table class="tabla_reporte" align="center">
    <thead>
        <tr class="titulo">
            <td rowspan="3">Item</td>
            <td rowspan="3" width="100">Nombre</td>
            <td width="100">Cargo</td>
            <td width="40">CI</td>
            <td width="40">NUA</td>
            <td width="40">Fecha Ingreso</td>
            <td width="40">Haber mensual</td>
            <td width="40">Dias</td>
            <td width="40">Haber basico</td>
            <td width="40">Bono ant.</td>
            <td width="40">Horas Extra</td>
            <td width="40">Suplen.</td>
            <td width="40">Total Ganado</td>
            <td rowspan="3" width="40">Liquido pagable</td>
            <td rowspan="3" width="150">Firma trabajador</td>                   
        </tr>
        <tr class="titulo">
            <td colspan="11" align="center">Descuentos</td>
        </tr>
        <tr class="titulo">
            <td width="100">Sind.</td>
            <td width="40">Cat. ind.</td>
            <td width="40">Prim. Riesgo C.</td>
            <td width="40">Com. al ente</td>
            <td width="40">Total apo. sol.</td>
            <td width="40">RCIVA 13%</td>
            <td width="40">Otros desc</td>
            <td width="40">Fondo social</td>
            <td width="40">Fondo Empl.</td>
            <td width="40">Ent. Finan.</td>
            <td width="40">Total Desc</td>
        </tr>
    </thead>
    <tbody>
 
<?php

    $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla");
    
    $sum_haber_basico = 0;
    $sum_bono_antiguedad = 0;
    $sum_extras = 0;
    $sum_suplencias = 0;
    $sum_total_ganado = 0;
    $sum_descuentos_afp = 0;
    $sum_prima_riesgo_comun = 0;
    $sum_comision_ente = 0;
    $sum_total_aporte_solidario = 0;
    $sum_descuentos_rciva = 0;
    $sum_descuento = 0;
    $sum_fondo_social = 0;
    $sum_fondo_empleados = 0;
    $sum_entidades_financieras = 0;
    $sum_total_descuentos = 0;
    $sum_liquido_pagable = 0;

    while($registro = $bd->getFila($registros))
        {
            echo "<tr><td rowspan='2'>$registro[item]</td><td rowspan='2' width='60'>$registro[apellidos] $registro[nombres]</td><td width='100'>$registro[cargo]</td><td align='center' width='40'>$registro[ci]</td><td align='center' width='40'>$registro[nua]</td><td align='right' width='40'>$registro[fecha_ingreso]</td><td align='right' width='40'>$registro[haber_mensual]</td><td  align='center' width='40'>$registro[dias_pagado]</td><td align='right' width='40'>$registro[haber_basico]</td><td  align='right' width='40'>$registro[bono_antiguedad]</td><td  align='right' width='40'>$registro[horas_extra]</td><td  align='right' width='40'>$registro[suplencia]</td><td  align='right' width='40'>$registro[total_ganado]</td><td  rowspan='2' align='right' width='40' >$registro[liquido_pagable]</td><td rowspan='2' width='150'></td></tr>

            <tr><td  align='right' width='100'>$registro[sindicato]</td><td  align='right' width='40'>$registro[categoria_individual]</td><td  align='right' width='40'>$registro[prima_riesgo_comun]</td><td  align='right' width='40'>$registro[comision_ente]</td><td  align='right' width='40'>$registro[total_aporte_solidario]</td><td  align='right' width='40'>$registro[desc_rciva]</td><td  align='right' width='40'>$registro[otros_descuentos]</td><td  align='right' width='40'>$registro[fondo_social]</td><td  align='right' width='40'>$registro[fondo_empleados]</td><td  align='right' width='40'>$registro[entidades_financieras]</td><td  align='right' width='40'>$registro[total_descuentos]</td></tr>";
            $sum_haber_basico = $sum_haber_basico + $registro[haber_basico];
            $sum_bono_antiguedad = $sum_bono_antiguedad + $registro[bono_antiguedad];
            $sum_extras = $sum_extras + $registro[horas_extra];
            $sum_suplencias = $sum_suplencias + $registro[suplencia];
            $sum_total_ganado = $sum_total_ganado + $registro[total_ganado];
            $sum_sindicato = $sum_sindicato + $registro[sindicato];
            $sum_descuentos_afp = $sum_descuentos_afp + $registro[categoria_individual];
            $sum_prima_riesgo_comun = $sum_prima_riesgo_comun + $registro[prima_riesgo_comun];
            $sum_comision_ente = $sum_comision_ente + $registro[comision_ente];
            $sum_total_aporte_solidario = $sum_total_aporte_solidario + $registro[total_aporte_solidario];
            $sum_descuentos_rciva = $sum_descuentos_rciva + $registro[desc_rciva];
            $sum_descuento = $sum_descuento + $registro[otros_descuentos];
            $sum_fondo_social = $sum_fondo_social + $registro[fondo_social];
            $sum_fondo_empleados = $sum_fondo_empleados + $registro[fondo_empleados];
            $sum_entidades_financieras = $sum_entidades_financieras + $registro[entidades_financieras];
            $sum_total_descuentos = $sum_total_descuentos + $registro[total_descuentos];
            $sum_liquido_pagable = $sum_liquido_pagable + $registro[liquido_pagable];
        }
    echo "<tr><td colspan='2' align='center' rowspan='2'>TOTALES</td><td rowspan='2' align='right'>".number_format($sum_sindicato,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_afp,2)."</td><td align='right' rowspan='2'>".number_format($sum_prima_riesgo_comun,2)."</td><td align='right' rowspan='2'>".number_format($sum_comision_ente,2)."</td><td align='right' rowspan='2'>".number_format($sum_total_aporte_solidario,2)."</td><td align='right'>".number_format($sum_descuentos_rciva,2)."</td><td align='right' rowspan='2'>".number_format($sum_haber_basico,2)."</td><td align='right'>".number_format($sum_bono_antiguedad,2)."</td><td align='right'>".number_format($sum_extras,2)."</td><td align='right'>".number_format($sum_suplencias,2)."</td><td align='right'>".number_format($sum_total_ganado,2)."</td><td align='right' rowspan='2'>".number_format($sum_liquido_pagable,2)."</td></tr><tr><td align='right'>".number_format($sum_descuento,2)."</td><td align='right'>".number_format($sum_fondo_social,2)."</td><td align='right'>".number_format($sum_fondo_empleados,2)."</td><td align='right'>".number_format($sum_entidades_financieras,2)."</td><td align='right'>".number_format($sum_total_descuentos,2)."</td></tr>";
?>
</tbody>
</table>
<?php

    echo "</page>";

    $content = ob_get_clean();

    try{
        $html2pdf = new HTML2PDF('L', 'Legal', 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("planilla_general.pdf");
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>