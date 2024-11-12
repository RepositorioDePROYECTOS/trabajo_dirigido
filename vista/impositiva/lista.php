<?php include("modelo/impositiva.php"); 
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];  
    $impositiva = new impositiva();
    $registros = $bd->Consulta("select * from impositiva i inner join asignacion_cargo ac on i.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join refrigerio r on ac.id_asignacion_cargo=r.id_asignacion_cargo where i.mes=$mes and i.gestion=$gestion and r.mes=$mes and r.gestion=$gestion order by cast(item as unsigned) asc");    
?>
<h2>Planilla impositiva Periodo: <?php echo $mes."/".$gestion;?><br /><br>
    <a href="control/impositiva/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=impositiva&pag=planilla_impositiva&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
    	Crear planilla<i class="entypo-plus"></i>
    </a>
    <a href="?mod=impositiva&pag=form_impositiva&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-warning btn-icon" style="float: right;margin-right: 5px;">
        Crear impositiva individual<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/impositiva/planilla_impositiva_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla impositiva<i class="entypo-print"></i>
    </a>
</h2>
<br /><br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th rowspan="2">Item</th>
        <th rowspan="2">Mes</th>
    	<th rowspan="2">Gestion</th>
    	<th rowspan="2">Trabajador</th>
        <th rowspan="2">Total Ganado</th>
        <th rowspan="2">Aporte laboral</th>
        <th rowspan="2">Refrigerio</th>
        <th rowspan="2">Sueldo neto</th>
    	<th rowspan="2">Minimo no imponible</th>
        <th rowspan="2">Base imponible</th>
        <th rowspan="2">Imp 13% BI</th>
        <th rowspan="2">IVA F110</th>
        <th rowspan="2">13% 2SM</th>
        <th colspan="2">Saldo a favor</th>
        <th colspan="3">Saldo ant a favor depen</th>
        <th rowspan="2">Saldo total depen</th>
        <th rowspan="2">Saldo utilizado</th>
        <th rowspan="2">Impuesto retenido a pagar</th>
        <th rowspan="2">Saldo depen sgte. mes</th>
        <th width="160" rowspan="2">Acciones</th>
	</tr>
    <tr>
        <th>Fisco</th>
        <th>Dependiente</th>
        <th>Mes ant.</th>
        <th>Actualiz.</th>
        <th>Total</th>
    </tr>
   </thead>
   <tbody>    
   <?php
    $n = 0;
        while($registro = $bd->getFila($registros)) 
        {
            echo "<tr>";        
            echo utf8_encode("<td>$registro[item]</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[total_ganado]</td><td>$registro[aportes_laborales]</td><td>$registro[total_refrigerio]</td><td>$registro[sueldo_neto]</td><td>$registro[minimo_no_imponible]</td><td>$registro[base_imponible]</td><td>$registro[impuesto_bi]</td><td>$registro[presentacion_desc]</td><td>$registro[impuesto_mn]</td><td>$registro[saldo_fisco]</td><td>$registro[saldo_dependiente]</td><td>$registro[saldo_mes_anterior]</td><td>$registro[actualizacion]</td><td>$registro[saldo_total_mes_anterior]</td><td>$registro[saldo_total_dependiente]</td><td>$registro[saldo_utilizado]</td><td>$registro[retencion_pagar]</td><td>$registro[saldo_siguiente_mes]</td>");
            echo "<td>
                       <a href='?mod=impositiva&pag=editar_impositiva&id=$registro[id_impositiva]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/impositiva/eliminar.php?id=$registro[id_impositiva]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                  </td>";
            echo "</tr>";
        }   
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    