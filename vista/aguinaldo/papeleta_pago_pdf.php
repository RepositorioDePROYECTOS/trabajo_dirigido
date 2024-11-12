<?php
    session_start();
    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    setlocale(LC_TIME,"es_ES");
    
    $id_nombre_planilla = $_SESSION[id];
    require_once('../reportes/cabeza_logo_papeleta.php');
    include("../../modelo/nombre_planilla.php");
    
    $nombre_planilla = new nombre_planilla();
    $nombre_planilla->get_nombre_planilla($id_nombre_planilla);
    $mes = $nombre_planilla->mes;
    $gestion = $nombre_planilla->gestion;
    $nombre_mes = getMes($mes);
    $registros = $bd->Consulta("select * from planilla p inner join cargo c on p.item=c.item inner join asignacion_cargo ac on ac.id_cargo=c.id_cargo inner join bono_antiguedad ba on ba.id_asignacion_cargo=ac.id_asignacion_cargo where p.id_nombre_planilla=$id_nombre_planilla and ba.mes=$mes and ba.gestion=$gestion and estado_planilla='APROBADO' order by cast(c.item as unsigned) asc");
    if($bd->numFila($registros) > 0)
    {
   while($registro = $bd->getFila($registros))
   {            
           include("../reportes/inicio_pagina_logo.php");
           $registros_imp = $bd->Consulta("select * from impositiva where id_asignacion_cargo=$registro[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
           $registro_imp = $bd->getFila($registros_imp);

           $registros_he = $bd->Consulta("select * from horas_extra where id_asignacion_cargo=$registro[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
           while($registro_he = $bd->getFila($registros_he))
           {
                if($registro_he[tipo_he] == 'DE 14 A 22')
                {
                    $ht_nocturna1 = $registro_he[monto];
                }
                else
                    if($registro_he[tipo_he] == 'DE 22 A 06')
                    {
                        $ht_nocturna2 = $registro_he[monto];
                    }
                    else
                        if($registro_he[tipo_he] == 'HORAS EXTRA NOCTURNO')
                        {
                            $he_nocturno = $registro_he[monto];
                        }
                        else
                            if($registro_he[tipo_he] == 'HORAS EXTRA')
                            {
                                $he = $registro_he[monto];
                            }
                            else
                                if($registro_he[tipo_he] == 'DOMINGOS')
                                {
                                    $he_domingos = $registro_he[monto];
                                }
           }
           $ht_nocturna = $ht_nocturna1 + $ht_nocturna2;
           if(empty($ht_nocturna))
           {
            $ht_nocturna = 0;
           }
           if(empty($he_nocturno))
           {
            $he_nocturno = 0;
           }
           if(empty($he))
           {
            $he = 0;
           }
           if(empty($he_domingos))
           {
            $he_domingos = 0;
           }
        ?>
        <table align="center" width="600" class="tabla_reporte">
            <tr class="titulo">
                <td colspan="2" width="350" align="center"><strong>PAPELETA DE PAGO DE HABERES</strong></td><td colspan="2" width="250" align="center"><strong>Correspondiente a:</strong> <?php echo $nombre_mes." ".$gestion;?> </td>
            </tr>
            <tr>
                <td width="120"><strong>ITEM:</strong></td><td width="230"><?php echo $registro[item];?></td><td width="160"><strong>FECHA INGRESO:</strong></td><td width="90"><?php echo $registro[fecha_ingreso];?></td>
            </tr>
            <tr>
                <td><strong>NOMBRE:</strong></td><td><?php echo $registro[nombres]." ".$registro[apellidos];?></td><td><strong>Nro. ASEGURADO:</strong></td><td></td>
            </tr>
            <tr>
                <td><strong>SECCION:</strong></td><td><?php echo $registro[seccion];?></td><td><strong>DIAS TRABAJADOS:</strong></td><td><?php echo $registro[dias_pagado];?></td>
            </tr>
            <tr>
                <td><strong>CARGO:</strong></td><td><?php echo $registro[cargo];?></td><td><strong>DIAS FALTA:</strong></td><td><?php echo (30 - $registro[dias_pagado]);?></td>
            </tr>
            <tr>
                <td><strong>CATEGORIA:</strong></td><td><?php echo $registro[porcentaje]."%";?></td><td><strong>FECHA DE PAGO:</strong></td><td><?php echo $registro[fecha_aprobado];?></td>
            </tr>
            <tr class="titulo">
                <td colspan="2" align="center"><strong>INGRESOS</strong></td><td colspan="2" align="center"><strong>DESCUENTOS</strong></td>
            </tr>
            <tr>
                <td>Haber B&aacute;sico</td><td><?php echo $registro[haber_basico];?></td><td>Descuento RC-IVA</td><td><?php echo $registro[desc_rciva];?></td>
            </tr>
            <tr>
                <td>Horas Trabajo Nocturno</td><td><?php echo number_format($ht_nocturna,2);?></td><td>Capitalizacion Individual</td><td><?php echo $registro[categoria_individual];?></td>
            </tr>
            <tr>
                <td>Horas Extras Nocturnas</td><td><?php echo number_format($he_nocturno,2);?></td><td>Muerte Invalidez Riesgos</td><td><?php echo $registro[prima_riesgo_comun];?></td>
            </tr>
            <tr>
                <td>Horas Extras</td><td><?php echo number_format($he,2);?></td><td>Comisi&oacute;n AFP</td><td><?php echo $registro[comision_ente];?></td>
            </tr>
            <tr>
                <td>Domingos Trabajados</td><td><?php echo number_format($he_domingos,2);?></td><td>Aporte Solidario</td><td><?php echo $registro[total_aporte_solidario];?></td>
            </tr>
            <tr>
                <td>Suplencia</td><td><?php echo $registro[suplencia];?></td><td>Otros Descuentos</td><td><?php echo $registro[otros_descuentos];?></td>
            </tr>
            <tr>
                <td>Bono Antiguedad</td><td><?php echo $registro[bono_antiguedad];?></td><td>Fondo Social ELAPAS</td><td><?php echo $registro[fondo_social];?></td>
            </tr>
            <tr>
                <td><strong>TOTAL GANADO</strong></td><td><strong><?php echo $registro[total_ganado];?></strong></td><td>Fondo de Empleados ELAPAS</td><td><?php echo $registro[fondo_empleados];?></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="3"></td><td>Descuento Sindical</td><td><?php echo number_format($registro[17],2);?></td>
            </tr>
            <tr>
                <td>Descuentos Entidades Financieras</td><td><?php echo $registro[entidades_financieras];?></td>
            </tr>
            <tr>
                <td><strong>TOTAL DESCUENTOS</strong></td><td><strong><?php echo $registro[total_descuentos];?></strong></td>
            </tr>
            <tr>
                <td><strong>LIQUIDO PAGABLE</strong></td><td><strong><?php echo $registro[liquido_pagable];?></strong></td><td colspan="2" rowspan="2"></td>
            </tr>
            <tr>
                <td><strong>SALDO A FAVOR RC-IVA</strong></td><td><strong><?php echo $registro_imp[saldo_siguiente_mes];?></strong></td>
            </tr>
            <tr>
                <td colspan="2"></td><td colspan="2" align="center"><strong>RECIBI CONFORME</strong></td>
            </tr>
        </table>
<?php
        echo "</page>";
        $ht_nocturna = 0;
        $he_nocturno = 0;
        $he = 0;
        $he_domingos = 0;
    }
}
else
{
    echo "No existen planillas aprobadas";
}
    $content = ob_get_clean();

    try{
        $html2pdf = new HTML2PDF('H', array(215.9, 139.7), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("papeletas_pago.pdf");
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>