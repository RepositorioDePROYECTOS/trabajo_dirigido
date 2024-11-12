<?php 
    include("modelo/horas_extra.php");    
    $horas_extra = new horas_extra();
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];
    
    $registros = $bd->Consulta("select * from horas_extra he inner join asignacion_cargo ac on he.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where he.mes=$mes and he.gestion=$gestion order by cast(ac.item as unsigned) asc");    
?>
<h2>Planilla de horas extra <?php echo $mes. " del ".$gestion; ?>
    <a href="?mod=horas_extra&pag=form_horas_extra&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right;">
        Registrar hora extra<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/horas_extra/planilla_horas_extra_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla horas extra<i class="entypo-print"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
    <tr>	
        <th>No</th>
    	<th>Mes</th>
    	<th>Gestion</th>
        <th>Trabajador</th>
    	<th>Tipo hora extra</th>
    	<th>Cantidad</th>
    	<th>Monto</th>
        <th width="100">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        $n++;
        echo "<tr>";        
                  
        echo utf8_encode("<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[tipo_he]</td><td>$registro[cantidad]</td><td>$registro[monto]</td>");
        echo "<td>
                   <a href='?mod=horas_extra&pag=editar_horas_extra&id=$registro[id_horas_extra]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/horas_extra/eliminar.php?id=$registro[id_horas_extra]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

