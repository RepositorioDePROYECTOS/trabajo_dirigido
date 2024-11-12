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
    $mes = $nombre_planilla->mes;
    $gestion = $nombre_planilla->gestion;
?>
        <h1 align="center">PLANILLA DE PAGO</h1>
        <p align="left"><strong>NOMBRE:</strong><?php echo $nombre_planilla->nombre_planilla;?><br/>
        <strong>MES:</strong><?php echo $mes;?><br/>
        <strong>GESTION:</strong><?php echo $gestion;?></p>
<table class="tabla_reporte" align="center">
    <thead>
        <tr class="titulo">
            <td rowspan="3" width="30" align="center">Item</td>
            <td rowspan="3" width="100" align="center">Nombre</td>
            <td width="100" align="center">Cargo</td>
            <td width="40" align="center">CI</td>
            <td width="40" align="center">NUA</td>
            <td width="40" align="center">Fecha Ingreso</td>
            <td width="40" align="center">Haber mensual</td>
            <td width="40" align="center">Dias</td>
            <td width="40" align="center">Haber basico</td>
            <td width="40" align="center">Bono ant.</td>
            <td width="40"align="center">Horas Extra</td>
            <td width="40" align="center">Suplen.</td>
            <td width="40" align="center">Total Ganado</td>
            <td rowspan="3" width="40" align="center">Liquido pagable</td>
            <td rowspan="3" width="150" align="center">Firma trabajador</td>                   
        </tr>
        <tr class="titulo">
            <td colspan="11" align="center">Descuentos</td>
        </tr>
        <tr class="titulo">
            <td width="100" align="center">Sind.</td>
            <td width="40" align="center">Cat. ind.</td>
            <td width="40" align="center">Prim. Riesgo C.</td>
            <td width="40" align="center">Com. al ente</td>
            <td width="40" align="center">Total aporte sol.</td>
            <td width="40" align="center">RCIVA 13%</td>
            <td width="40" align="center">Otros desc.</td>
            <td width="40" align="center">Fondo social</td>
            <td width="40" align="center">Fondo Empl.</td>
            <td width="40" align="center">Ent. Finan.</td>
            <td width="40" align="center">Total Desc.</td>
        </tr>
    </thead>
    <tbody>
 
<?php

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

    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='15' align='center'>SECCION $registro_c[0]</td></tr>";
        
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

        $registros_ac = $bd->Consulta("select * from cargo where seccion='$registro_c[seccion]' and estado_cargo<>'DESHABILITADO' order by cast(item as unsigned) asc" );

        while($registro_ac = $bd->getFila($registros_ac))
        {
            $registros_pl = $bd->Consulta("select * from planilla where mes=$mes and gestion=$gestion and item=$registro_ac[item]");
            $registro_pl = $bd->getFila($registros_pl);

            if(!empty($registro_pl))
            {

                $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla and item=$registro_ac[item]");
                $registro = $bd->getFila($registros);

                $registros_he = $bd->Consulta("select * from horas_extra he inner join asignacion_cargo ac on he.id_asignacion_cargo=ac.id_asignacion_cargo where item=$registro_pl[item] and mes=$mes and gestion=$gestion");
                $registro_he = $bd->getFila($registros_he);
                
                echo "<tr><td rowspan='2' width='30'>$registro[item]</td><td rowspan='2' width='60'>".utf8_encode($registro[apellidos])." ".utf8_encode($registro[nombres])."</td><td width='100'>".utf8_encode($registro[cargo])."</td><td align='center' width='40'>$registro[ci]</td><td align='center' width='40'>$registro[nua]</td><td align='right' width='40'>$registro[fecha_ingreso]</td><td align='right' width='40'>$registro[haber_mensual]</td><td  align='center' width='40'>$registro[dias_pagado]</td><td align='right' width='40'>$registro[haber_basico]</td><td  align='right' width='40'>$registro[bono_antiguedad]</td><td  align='right' width='40'>";
                if(empty($registro_he[cantidad]))
                {
                    echo $registro[horas_extra];
                }
                else
                {
                    echo "(".$registro_he[cantidad].") ".$registro[horas_extra];
                }
                echo "</td><td  align='right' width='40'>$registro[suplencia]</td><td  align='right' width='40'>$registro[total_ganado]</td><td  rowspan='2' align='right' width='40' >$registro[liquido_pagable]</td><td rowspan='2' width='150' align='right'>$registro[item]</td></tr>

                        <tr><td  align='right' width='100'>$registro[sindicato]</td><td  align='right' width='40'>$registro[categoria_individual]</td><td  align='right' width='40'>$registro[prima_riesgo_comun]</td><td  align='right' width='40'>$registro[comision_ente]</td><td  align='right' width='40'>$registro[total_aporte_solidario]</td><td  align='right' width='40'>$registro[desc_rciva]</td><td  align='right' width='40'>$registro[otros_descuentos]</td><td  align='right' width='40'>$registro[fondo_social]</td><td  align='right' width='40'>$registro[fondo_empleados]</td><td  align='right' width='40'>$registro[entidades_financieras]</td><td  align='right' width='40'>$registro[total_descuentos]</td></tr>";
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
            else
            {
                echo "<tr><td width='30'>".utf8_encode($registro_ac[1])."</td><td width='60'></td><td width='100'>".utf8_encode($registro_ac[descripcion])."</td><td width='40'></td><td width='40'></td><td width='40'></td><td align='right' width='40'>$registro_ac[salario_mensual]</td><td colspan='8' align='center' width='430'>ACEFALIA</td></tr>";

            }
        }
        echo "<tr bgcolor='#d3ded5'><td colspan='2' align='center' rowspan='2'>TOTAL SECCION</td><td rowspan='2' align='right'>".number_format($sum_sindicato_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_afp_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_prima_riesgo_comun_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_comision_ente_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_total_aporte_solidario_s,2)."</td><td align='right'  rowspan='2'>".number_format($sum_descuentos_rciva_s,2)."</td><td align='right'>".number_format($sum_haber_basico_s,2)."</td><td align='right'>".number_format($sum_bono_antiguedad_s,2)."</td><td align='right'>".number_format($sum_extras_s,2)."</td><td align='right'>".number_format($sum_suplencias_s,2)."</td><td align='right'>".number_format($sum_total_ganado_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_liquido_pagable_s,2)."</td><td rowspan='2'></td></tr><tr bgcolor='#d3ded5'><td align='right'>".number_format($sum_descuento_s,2)."</td><td align='right'>".number_format($sum_fondo_social_s,2)."</td><td align='right'>".number_format($sum_fondo_empleados_s,2)."</td><td align='right'>".number_format($sum_entidades_financieras_s,2)."</td><td align='right'>".number_format($sum_total_descuentos_s,2)."</td></tr>";
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
    echo "<tr><td colspan='2' align='center' rowspan='2'>TOTALES</td><td rowspan='2' align='right'>".number_format($sum_sindicato,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_afp,2)."</td><td align='right' rowspan='2'>".number_format($sum_prima_riesgo_comun,2)."</td><td align='right' rowspan='2'>".number_format($sum_comision_ente,2)."</td><td align='right' rowspan='2'>".number_format($sum_total_aporte_solidario,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_rciva,2)."</td><td align='right'>".number_format($sum_haber_basico,2)."</td><td align='right'>".number_format($sum_bono_antiguedad,2)."</td><td align='right'>".number_format($sum_extras,2)."</td><td align='right'>".number_format($sum_suplencias,2)."</td><td align='right'>".number_format($sum_total_ganado,2)."</td><td align='right' rowspan='2'>".number_format($sum_liquido_pagable,2)."</td></tr><tr><td align='right'>".number_format($sum_descuento,2)."</td><td align='right'>".number_format($sum_fondo_social,2)."</td><td align='right'>".number_format($sum_fondo_empleados,2)."</td><td align='right'>".number_format($sum_entidades_financieras,2)."</td><td align='right'>".number_format($sum_total_descuentos,2)."</td></tr>";
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
        $html2pdf->Output("planilla_general.pdf");
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>