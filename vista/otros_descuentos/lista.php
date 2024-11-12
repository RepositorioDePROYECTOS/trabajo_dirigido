<?php include("modelo/otros_descuentos.php"); 
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];  
    $otros_descuentos = new otros_descuentos();
    $verificars = $bd->Consulta("select * from total_ganado where mes=$mes and gestion=$gestion");
    $verificar = $bd->getFila($verificars);
    if(empty($verificar))
    {
        $registros = $bd->Consulta("select d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, ac.salario as haber_basico, ac.salario as total_ganado, d.descripcion, d.monto_od, d.id_otros_descuentos from otros_descuentos d inner join asignacion_cargo ac on d.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where d.mes=$mes and d.gestion=$gestion  group by d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, haber_basico, total_ganado, d.descripcion, d.monto_od, d.id_otros_descuentos order by cast(ac.item as unsigned) asc");
    }
    else
    {
        $registros = $bd->Consulta("select d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, tg.haber_basico, tg.total_ganado, d.descripcion, d.monto_od, d.id_otros_descuentos from otros_descuentos d inner join asignacion_cargo ac on d.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join total_ganado tg on ac.id_asignacion_cargo=tg.id_asignacion_cargo where d.mes=$mes and d.gestion=$gestion and tg.mes=$mes and tg.gestion=$gestion group by d.mes, d.gestion, t.nombres, t.apellido_paterno, t.apellido_materno, tg.haber_basico, tg.total_ganado, d.descripcion, d.monto_od, d.id_otros_descuentos order by cast(ac.item as unsigned) asc");  
    }
      
?>    
    <a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
    </a><br>
<h2>OTROS DESCUENTOS PERIODO <?php echo $mes."/".$gestion;?><br><br>

    <a href="control/otros_descuentos/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=otros_descuentos&pag=planilla_otros_descuentos&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
    	Crear planilla<i class="entypo-plus"></i>
    </a>
    <a href="?mod=otros_descuentos&pag=form_otros_descuentos&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right;margin-right: 5px;">
        Crear descuento individual<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/otros_descuentos/planilla_otros_descuentos_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla otros descuentos<i class="entypo-print"></i>
    </a>
    <br><br>
    <a href="?mod=otros_descuentos&pag=planilla_prueba_otros_descuentos&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-warning btn-icon" style="float: right; margin-right: 5px;">
        Crear prueba planilla<i class="entypo-plus"></i>
    </a>
</h2>
<br /><br>
<br>
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Mes</th>
    	<th>Gestion</th>
    	<th>Trabajador</th>
        <th>Haber B&aacute;sico</th>
        <th>Total Ganado</th>
        <th>Descripcion</th>
    	<th>Monto</th>
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
            echo utf8_encode("	<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[haber_basico]</td><td>$registro[total_ganado]</td><td>$registro[descripcion]</td><td>$registro[monto_od]</td>");
            echo "<td>
            	       <a href='?mod=otros_descuentos&pag=editar_otros_descuentos&id=$registro[id_otros_descuentos]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/otros_descuentos/eliminar.php?id=$registro[id_otros_descuentos]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    