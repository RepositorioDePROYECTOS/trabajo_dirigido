<?php include("modelo/aporte_laboral.php"); 
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];  
    $aporte_laboral = new aporte_laboral();
    $registros = $bd->Consulta("select * from aporte_laboral al inner join asignacion_cargo ac on al.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where al.mes=$mes and al.gestion=$gestion");    
?>
<h2>APORTES LABORALES <?php echo $mes."/".$gestion;?><br><br>
    <a href="control/aporte_laboral/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=aporte_laboral&pag=planilla_aporte_laboral&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
    	Crear planilla<i class="entypo-plus"></i>
    </a>
    <a href="?mod=aporte_laboral&pag=form_aporte_laboral&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-warning btn-icon" style="float: right;margin-right: 5px;">
        Crear aporte individual<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/aporte_laboral/planilla_aporte_laboral_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla aporte laboral<i class="entypo-print"></i>
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
        <th>Total Ganado</th>
        <th>Tipo aporte</th>
        <th>Porcentaje</th>
    	<th>Monto aporte</th>
        <th width="160">Acciones</th>
	</tr>
   </thead>
   <tbody>    
   <?php
        $n = 0;
        while($registro = $bd->getFila($registros)) 
        {
            $registros_tg = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion and id_asignacion_cargo=$registro[id_asignacion_cargo]");
            $registro_tg = $bd->getFila($registros_tg);
            $total_ganado = $registro_tg[total_ganado];
            $n++;
            echo "<tr>";        
            echo utf8_encode("	<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$total_ganado</td><td>$registro[tipo_aporte]</td><td>$registro[porc_aporte]</td><td>$registro[monto_aporte]</td>");
            echo "<td>
            	       <a href='?mod=aporte_laboral&pag=editar_aporte_laboral&id=$registro[id_aporte_laboral]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/aporte_laboral/eliminar.php?id=$registro[id_aporte_laboral]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    