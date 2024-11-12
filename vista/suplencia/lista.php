<?php 
    include("modelo/suplencia.php");    
    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];
    $suplencia = new suplencia();
    $registros = $bd->Consulta("select * from suplencia su inner join asignacion_cargo ac on su.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where su.mes=$mes and su.gestion=$gestion");    
?>
<h2>Planilla de suplencias <?php echo $mes. " del ".$gestion; ?>
    <a href="?mod=suplencia&pag=form_suplencia&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right;">
        Registrar suplencia<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/suplencia/planilla_suplencia_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla suplencias<i class="entypo-print"></i>
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
    	<th>Fecha inicio</th>
    	<th>Fecha fin</th>
    	<th>Total dias</th>
        <th>Cargo suplencia</th>
        <th>Salario</th>
        <th>Monto x Suplencia</th>
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
                  
        echo utf8_encode("<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[fecha_inicio]</td><td>$registro[fecha_fin]</td><td>$registro[total_dias]</td><td>$registro[cargo_suplencia]</td><td>$registro[salario_mensual]</td><td>$registro[monto]</td>");
        echo "<td>
                   <a href='?mod=suplencia&pag=editar_suplencia&id=$registro[id_suplencia]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/suplencia/eliminar.php?id=$registro[id_suplencia]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

