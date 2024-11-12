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
        <h1 align="center">RESUMEN PLANILLA DE PAGO</h1>
        <p align="left"><strong>NOMBRE: </strong> RESUMEN <?php echo $nombre_planilla->nombre_planilla;?><br/>
        <strong>MES:</strong><?php echo $nombre_planilla->mes;?><br/>
        <strong>GESTION:</strong><?php echo $nombre_planilla->gestion;?></p>
<table class="tabla_reporte" align="center">
   
        <tr align="center" bgcolor='#d3ded5'> 
            <td width="100">CONCEPTO</td>
            <td width="50">HABER BASICO</td>
            <td width="50">BONO ANTIGUEDAD</td>
            <td width="50">HORAS EXTRA</td>
            <td width="50">SUPLENCIA</td>
            <td width="50">TOTAL GANADO</td>
            <td width="50">SINDICATO</td>
            <td width="50">CATEGORIA INDIVIDUAL</td>
            <td width="50">PRIMA RIESGO COMUN</td>
            <td width="50">COMISION AL ENTE ADMINISTRADOR</td>
            <td width="50">TOTAL APORTE SOLIDARIO</td>
            <td width="50">RC-IVA 13%</td>
            <td width="50">OTROS DESCUENTOS</td>
            <td width="50">FONDO SOCIAL</td>
            <td width="50">FONDO DE EMPLEADOS</td>
            <td width="50">ENTIDADES FINANCIERAS</td>
        </tr>
<?php
    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum_haber_basico = 0;
    $sum_bono_antiguedad = 0;
    $sum_extras = 0;
    $sum_suplencias = 0;
    $sum_sindicato = 0;
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
    while($registro_c = $bd->getFila($registros_c))
    {
        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc");
        $sum_haber_basico_s = 0;
        $sum_bono_antiguedad_s = 0;
        $sum_extras_s = 0;
        $sum_suplencias_s = 0;
        $sum_sindicato_s = 0;
        $sum_total_ganado_s = 0;
        $sum_descuentos_afp_s = 0;
        $sum_prima_riesgo_comun_s = 0;
        $sum_comision_ente_s = 0;
        $sum_total_aporte_solidario_s = 0;
        $sum_descuentos_rciva_s = 0;
        $sum_descuento_s = 0;
        $sum_fondo_social_s = 0;
        $sum_fondo_empleados_s = 0;
        $sum_entidades_financieras_s = 0;
        $sum_total_descuentos_s = 0;
        $sum_liquido_pagable_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {

                $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla and item=$registro_ac[item]");
                
                $registros_he = $bd->Consulta("select * from horas_extra where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$nombre_planilla->mes and gestion=$nombre_planilla->gestion");
                $registro_he = $bd->getFila($registros_he);
                $registro = $bd->getFila($registros);
                
                $sum_haber_basico_s = $sum_haber_basico_s + $registro[haber_basico];
                $sum_bono_antiguedad_s = $sum_bono_antiguedad_s + $registro[bono_antiguedad];
                $sum_extras_s = $sum_extras_s + $registro[horas_extra];
                $sum_suplencias_s = $sum_suplencias_s + $registro[suplencia];
                $sum_total_ganado_s = $sum_total_ganado_s + $registro[total_ganado];
                $sum_sindicato_s = $sum_sindicato_s + $registro[17];
                $sum_descuentos_afp_s = $sum_descuentos_afp_s + $registro[categoria_individual];
                $sum_prima_riesgo_comun_s = $sum_prima_riesgo_comun_s + $registro[prima_riesgo_comun];
                $sum_comision_ente_s = $sum_comision_ente_s + $registro[comision_ente];
                $sum_total_aporte_solidario_s = $sum_total_aporte_solidario_s + $registro[total_aporte_solidario];
                $sum_descuentos_rciva_s = $sum_descuentos_rciva_s + $registro[desc_rciva];
                $sum_descuento_s = $sum_descuento_s + $registro[otros_descuentos];
                $sum_fondo_social_s = $sum_fondo_social_s + $registro[fondo_social];
                $sum_fondo_empleados_s = $sum_fondo_empleados_s + $registro[fondo_empleados];
                $sum_entidades_financieras_s = $sum_entidades_financieras_s + $registro[entidades_financieras];
                $sum_total_descuentos_s = $sum_total_descuentos_s + $registro[total_descuentos];
                $sum_liquido_pagable_s = $sum_liquido_pagable_s + $registro[liquido_pagable];
            }
            
        }

        echo "<tr><td align='left' width='100'>TOTAL $registro_c[0]</td><td align='right'>".number_format($sum_haber_basico_s,2)."</td><td align='right'>".number_format($sum_bono_antiguedad_s,2)."</td><td align='right'>".number_format($sum_extras_s,2)."</td><td align='right'>".number_format($sum_suplencias_s,2)."</td><td align='right'>".number_format($sum_total_ganado_s,2)."</td><td align='right'>".number_format($sum_sindicato_s,2)."</td><td align='right'>".number_format($sum_descuentos_afp_s,2)."</td><td align='right'>".number_format($sum_prima_riesgo_comun_s,2)."</td><td align='right'>".number_format($sum_comision_ente_s,2)."</td><td align='right'>".number_format($sum_total_aporte_solidario_s,2)."</td><td align='right'>".number_format($sum_descuentos_rciva_s,2)."</td><td align='right'>".number_format($sum_descuento_s,2)."</td><td align='right'>".number_format($sum_fondo_social_s,2)."</td><td align='right'>".number_format($sum_fondo_empleados_s,2)."</td><td align='right'>".number_format($sum_entidades_financieras_s,2)."</td></tr>";

        
        $sum_haber_basico = $sum_haber_basico_s + $sum_haber_basico;
        $sum_bono_antiguedad = $sum_bono_antiguedad_s + $sum_bono_antiguedad;
        $sum_extras = $sum_extras_s + $sum_extras;
        $sum_suplencias = $sum_suplencias_s + $sum_suplencias;
        $sum_total_ganado = $sum_total_ganado_s + $sum_total_ganado;
        $sum_sindicato = $sum_sindicato_s + $sum_sindicato;
        $sum_descuentos_afp = $sum_descuentos_afp_s + $sum_descuentos_afp;
        $sum_prima_riesgo_comun = $sum_prima_riesgo_comun_s + $sum_prima_riesgo_comun;
        $sum_comision_ente = $sum_comision_ente_s + $sum_comision_ente;
        $sum_total_aporte_solidario = $sum_total_aporte_solidario_s + $sum_total_aporte_solidario;
        $sum_descuentos_rciva = $sum_descuentos_rciva_s + $sum_descuentos_rciva;
        $sum_descuento = $sum_descuento_s + $sum_descuento;
        $sum_fondo_social = $sum_fondo_social_s + $sum_fondo_social;
        $sum_fondo_empleados = $sum_fondo_empleados_s + $sum_fondo_empleados;
        $sum_entidades_financieras = $sum_entidades_financieras_s + $sum_entidades_financieras;
        $sum_total_descuentos = $sum_total_descuentos_s + $sum_total_descuentos;
        $sum_liquido_pagable = $sum_liquido_pagable_s + $sum_liquido_pagable;
    }
    echo "<tr bgcolor='#d3ded5'><td>TOTAL GENERAL</td><td align='right'>".number_format($sum_haber_basico,2)."</td><td align='right'>".number_format($sum_bono_antiguedad,2)."</td><td align='right'>".number_format($sum_extras,2)."</td><td align='right'>".number_format($sum_suplencias,2)."</td><td align='right'>".number_format($sum_total_ganado,2)."</td><td align='right'>".number_format($sum_sindicato,2)."</td><td align='right'>".number_format($sum_descuentos_afp,2)."</td><td align='right'>".number_format($sum_prima_riesgo_comun,2)."</td><td align='right'>".number_format($sum_comision_ente,2)."</td><td align='right'>".number_format($sum_total_aporte_solidario,2)."</td><td align='right'>".number_format($sum_descuentos_rciva,2)."</td><td align='right'>".number_format($sum_descuento,2)."</td><td align='right'>".number_format($sum_fondo_social,2)."</td><td align='right'>".number_format($sum_fondo_empleados,2)."</td><td align='right'>".number_format($sum_entidades_financieras,2)."</td></tr>";

    
?>
</table>
<br><br><br><br>
<table align="center">
    <tr>
        <td align="center">Lic. Teofilo Vargas Caba<br>JEFE ADMINISTRATIVO Y PERSONAL</td><td width="20"></td><td align="center">Lic. Doris Vargas Mendoza<br>JEFE FINANCIERO Y CONTABLE</td><td width="20"></td><td align="center">Lic. Roxana Sarmiento Quinteros<br>GERENTE ADMINISTRATIVO Y FINANCIERO</td><td width="20"></td><td align="center">Ing. Wilhelm Pierola Iturralde<br> GERENTE GENERAL</td>
    </tr>
</table>
<?php

    echo "</page>";

    $content = ob_get_clean();

    try{
        $html2pdf = new HTML2PDF('L', 'Legal', 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("resumen_planilla.pdf");
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>