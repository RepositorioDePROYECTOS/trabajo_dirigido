<?php include("modelo/refrigerio.php");
    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];   
    $refrigerio = new refrigerio();
   
   $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");

       
?>
<h2>Lista de Refrigerio Periodo  <?php echo $mes;?>/<?php echo $gestion;?> </h2></br></br>
    <a href="control/refrigerio/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=refrigerio&pag=todos_refrigerio&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/refrigerio/planilla_refrigerio_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Refrigerio<i class="entypo-print"></i>
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
    <th>Dias laborables</th>
  	<th>Dias asistencia</th>
    <th>Monto d&iacute;a</th>
    <th>Otros</th>
    <th>Total Refrigerio</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
    while($registro_c = $bd->getFila($registros_c))
    {
      
      $registros = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo left join trabajador t on t.id_trabajador=ac.id_trabajador left join refrigerio r on r.id_asignacion_cargo=ac.id_asignacion_cargo where r.mes=$mes and r.gestion=$gestion and c.seccion='$registro_c[0]'");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$registro[item]</td><td>$registro[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[dias_laborables]</td><td>$registro[dias_asistencia]</td><td>$registro[monto_refrigerio]</td><td>$registro[otros]</td><td>$registro[total_refrigerio]</td>");
          echo "<td>
                     <a href='?mod=refrigerio&pag=editar_refrigerio&id=$registro[id_refrigerio]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                     
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

