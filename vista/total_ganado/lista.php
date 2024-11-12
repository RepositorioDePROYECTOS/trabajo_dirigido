<?php include("modelo/total_ganado.php"); 
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];  
    $total_ganado = new total_ganado();
    $registros = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where tg.mes=$mes and tg.gestion=$gestion");    
?>
<h2>TOTALES GANADO PERIODO <?php echo $mes."/".$gestion;?><br><br>
    <a href="control/total_ganado/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=total_ganado&pag=planilla_total_ganado&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
    	Crear planilla<i class="entypo-plus"></i>
    </a>
    <a href="?mod=total_ganado&pag=total_ganado_individual&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right;margin-right: 5px;">
        Crear total ganado individual<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/total_ganado/planilla_total_ganado_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla total ganado<i class="entypo-print"></i>
    </a>
</h2>
<br /><br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Mes</th>
    	<th>Gestion</th>
    	<th>Trabajador</th>
        <th>Cargo</th>
        <th>Total d&iacute;as</th>
        <th>Haber mensual</th>
    	<th>Haber b&aacute;sico</th>
        <th>Bono antiguedad</th>
        <th>Horas extra</th>
        <th>Monto hrs extra</th>
        <th>Suplencia</th>
        <th>Total ganado</th>
        <th width="160">Acciones</th>
	</tr>
   </thead>
   <tbody>    
   <?php
        $n = 0;
        while($registro = $bd->getFila($registros)) 
        {
            
            $n++;
            echo "<tr>";        
            echo utf8_encode("<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[cargo]</td><td>$registro[total_dias]</td><td>$registro[haber_mensual]</td><td>$registro[haber_basico]</td><td>$registro[bono_antiguedad]</td><td>$registro[nro_horas_extra]</td><td>$registro[monto_horas_extra]</td><td>$registro[suplencia]</td><td>$registro[total_ganado]</td>");
            echo "<td>
            	       <a href='?mod=total_ganado&pag=editar_total_ganado&id=$registro[id_total_ganado]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/total_ganado/eliminar.php?id=$registro[id_total_ganado]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    