<?php
  include("modelo/planilla.php");
  include("modelo/nombre_planilla.php");

  $id_nombre_planilla = $_GET[id];

  $nombre_planilla = new nombre_planilla();
  $planilla = new planilla();

  $nombre_planilla->get_nombre_planilla($id_nombre_planilla);
      
  $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla order by cast(item as unsigned) asc");
  
?>
<a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
</a>

<a target="_blank" href="vista/planilla/planilla_excel.php?id=<?php echo $id_nombre_planilla;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
        Lista excel <i class="entypo-export"></i>
</a>
<a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/planilla/resumen_pdf.php&id=<?php echo $id_nombre_planilla; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Imprimir<i class="entypo-print"></i>
    </a>
  
  
<br />
<h3>
  <strong>RESUMEN:</strong><?php echo $nombre_planilla->nombre_planilla;?><br/>
  <strong>Gesti&oacute;n:</strong><?php echo $nombre_planilla->gestion;?><br/>
  <strong>Mes:</strong><?php echo $nombre_planilla->mes;?><br/>
</h3>
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
  	<th>Cocepto</th>
  	<th>HABER BASICO</th>
    <th>BONO ANTIGUEDAD</th>
  	<th>HORAS EXTRA</th>
  	<th>SUPLENCIA</th>
  	<th>TOTAL GANADO</th>
  	<th>SINDICATO</th>
    <th>CATEGORIA INDIVIDUAL</th>
    <th>PRIMA RIESGO COMUN</th>
    <th>COMISION AL ENTE ADMINISTRADOR</th>
    <th>TOTAL APORTE SOLIDARIO</th>
    <th>RC-IVA 13%</th>
    <th>OTROS DESCUENTOS</th>
    <th>FONDO SOCIAL</th>
    <th>FONDO DE EMPLEADOS</th>
    <th>ENTIDADES FINANCIERAS</th>
  </tr>
</thead>
<tbody>    
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

        echo "<tr><td align='center'>TOTAL $registro_c[0]</td><td align='right'>".number_format($sum_haber_basico_s,2)."</td><td align='right'>".number_format($sum_bono_antiguedad_s,2)."</td><td align='right'>".number_format($sum_extras_s,2)."</td><td align='right'>".number_format($sum_suplencias_s,2)."</td><td align='right'>".number_format($sum_total_ganado_s,2)."</td><td align='right'>".number_format($sum_sindicato_s,2)."</td><td align='right'>".number_format($sum_descuentos_afp_s,2)."</td><td align='right'>".number_format($sum_prima_riesgo_comun_s,2)."</td><td align='right'>".number_format($sum_comision_ente_s,2)."</td><td align='right'>".number_format($sum_total_aporte_solidario_s,2)."</td><td align='right'>".number_format($sum_descuentos_rciva_s,2)."</td><td align='right'>".number_format($sum_descuento_s,2)."</td><td align='right'>".number_format($sum_fondo_social_s,2)."</td><td align='right'>".number_format($sum_fondo_empleados_s,2)."</td><td align='right'>".number_format($sum_entidades_financieras_s,2)."</td></tr>";

        //echo "<tr bgcolor='#d3ded5'><td colspan='2' align='center' rowspan='2'>TOTAL SECCION</td><td rowspan='2' align='right'>".number_format($sum_sindicato_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_afp_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_prima_riesgo_comun_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_comision_ente_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_total_aporte_solidario_s,2)."</td><td align='right'  rowspan='2'>".number_format($sum_descuentos_rciva_s,2)."</td><td align='right'>".number_format($sum_haber_basico_s,2)."</td><td align='right'>".number_format($sum_bono_antiguedad_s,2)."</td><td align='right'>".number_format($sum_extras_s,2)."</td><td align='right'>".number_format($sum_suplencias_s,2)."</td><td align='right'>".number_format($sum_total_ganado_s,2)."</td><td align='right' rowspan='2'>".number_format($sum_liquido_pagable_s,2)."</td><td rowspan='2'></td></tr><tr bgcolor='#d3ded5'><td align='right'>".number_format($sum_descuento_s,2)."</td><td align='right'>".number_format($sum_fondo_social_s,2)."</td><td align='right'>".number_format($sum_fondo_empleados_s,2)."</td><td align='right'>".number_format($sum_entidades_financieras_s,2)."</td><td align='right'>".number_format($sum_total_descuentos_s,2)."</td></tr>";
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
    echo "<tr><td>TOTAL GENERAL</td><td align='right'>".number_format($sum_haber_basico,2)."</td><td align='right'>".number_format($sum_bono_antiguedad,2)."</td><td align='right'>".number_format($sum_extras,2)."</td><td align='right'>".number_format($sum_suplencias,2)."</td><td align='right'>".number_format($sum_total_ganado,2)."</td><td align='right'>".number_format($sum_sindicato,2)."</td><td align='right'>".number_format($sum_descuentos_afp,2)."</td><td align='right'>".number_format($sum_prima_riesgo_comun,2)."</td><td align='right'>".number_format($sum_comision_ente,2)."</td><td align='right'>".number_format($sum_total_aporte_solidario,2)."</td><td align='right'>".number_format($sum_descuentos_rciva,2)."</td><td align='right'>".number_format($sum_descuento,2)."</td><td align='right'>".number_format($sum_fondo_social,2)."</td><td align='right'>".number_format($sum_fondo_empleados,2)."</td><td align='right'>".number_format($sum_entidades_financieras,2)."</td></tr>";

    //echo "<tr><td colspan='2' align='center' rowspan='2'>TOTALES</td><td rowspan='2' align='right'>".number_format($sum_sindicato,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_afp,2)."</td><td align='right' rowspan='2'>".number_format($sum_prima_riesgo_comun,2)."</td><td align='right' rowspan='2'>".number_format($sum_comision_ente,2)."</td><td align='right' rowspan='2'>".number_format($sum_total_aporte_solidario,2)."</td><td align='right' rowspan='2'>".number_format($sum_descuentos_rciva,2)."</td><td align='right'>".number_format($sum_haber_basico,2)."</td><td align='right'>".number_format($sum_bono_antiguedad,2)."</td><td align='right'>".number_format($sum_extras,2)."</td><td align='right'>".number_format($sum_suplencias,2)."</td><td align='right'>".number_format($sum_total_ganado,2)."</td><td align='right' rowspan='2'>".number_format($sum_liquido_pagable,2)."</td></tr><tr><td align='right'>".number_format($sum_descuento,2)."</td><td align='right'>".number_format($sum_fondo_social,2)."</td><td align='right'>".number_format($sum_fondo_empleados,2)."</td><td align='right'>".number_format($sum_entidades_financieras,2)."</td><td align='right'>".number_format($sum_total_descuentos,2)."</td></tr>";
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    