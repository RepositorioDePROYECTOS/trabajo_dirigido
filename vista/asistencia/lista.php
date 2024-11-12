<?php include("modelo/asistencia.php");
    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];   
    $asistencia = new asistencia();
   
   $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");

       
?>
<h2>Lista de Asistencia Periodo  <?php echo $mes;?>/<?php echo $gestion;?> </h2></br></br>
    <a href="control/asistencia/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
   <a href="?mod=asistencia&pag=form_asistencia&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
        Crear asistencia individual<i class="entypo-plus"></i>
    </a>
    <a href="?mod=asistencia&pag=todos_asistencia&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/asistencia/planilla_asistencia_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Asistencia<i class="entypo-print"></i>
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
  	<th>Dias trabajados</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
    while($registro_c = $bd->getFila($registros_c))
    {
      
      $registros = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo left join trabajador t on t.id_trabajador=ac.id_trabajador left join asistencia a on a.id_asignacion_cargo=ac.id_asignacion_cargo where a.mes=$mes and a.gestion=$gestion and c.seccion='$registro_c[0]'");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$registro[item]</td><td>$registro[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[dias_laborables]</td><td>$registro[dias_asistencia]</td>");
          echo "<td>
                     <a href='?mod=asistencia&pag=editar_asistencia&id=$registro[id_asistencia]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                     <a href='control/asistencia/eliminar.php?id=$registro[id_asistencia]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                     
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

