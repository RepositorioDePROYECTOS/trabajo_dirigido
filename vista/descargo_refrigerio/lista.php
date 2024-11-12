<?php include("modelo/descargo_refrigerio.php");
    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];   
    $descargo_refrigerio = new descargo_refrigerio();
   
   $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");

       
?>
<h2>Lista descargo para refrigerio Periodo  <?php echo $mes;?>/<?php echo $gestion;?> </h2></br></br>
    <a href="control/descargo_refrigerio/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=descargo_refrigerio&pag=todos_descargo_refrigerio&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/descargo_refrigerio/planilla_descargo_refrigerio_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla descargo<i class="entypo-print"></i>
    </a>

</h2>
<br /><br /><br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>Item</th>
  	<th>Cargo</th>
  	<th>Nombre</th>
    <th>Dias Computables</th>
  	<th>Dias asistencia</th>
    <th>Monto refrigerio</th>
    <th>Monto descargo</th>
    <th>Retencion</th>
    <th>Total Refrigerio</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
    while($registro_c = $bd->getFila($registros_c))
    {
      
      $registros = $bd->Consulta("select * from cargo c inner join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join asistencia_refrigerio a on a.id_asignacion_cargo=ac.id_asignacion_cargo inner join descargo_refrigerio d on d.id_asistencia_refrigerio=a.id_asistencia_refrigerio where d.mes=$mes and d.gestion=$gestion and c.seccion='$registro_c[0]'");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$registro[item]</td><td>$registro[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[dias_laborables]</td><td>$registro[dias_asistencia]</td><td>$registro[monto_refrigerio]</td><td>$registro[monto_descargo]</td><td>$registro[retencion]</td><td>$registro[total_refrigerio]</td>");
          echo "<td>
                     <a href='?mod=descargo_refrigerio&pag=editar_descargo_refrigerio&id=$registro[id_descargo_refrigerio]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                     
                </td>";
          echo "</tr>";
      }   
    }

   
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

