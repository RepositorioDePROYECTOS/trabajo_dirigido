<?php include("modelo/detalle_vacacion.php");
    
$id_vacacion = security($_GET[id]);

$detalle_vacacion = new detalle_vacacion();
$registros_v =  $bd->Consulta("select * from vacacion v inner join trabajador t on v.id_trabajador=t.id_trabajador where v.id_vacacion=$id_vacacion");
$registro_v = $bd->getFila($registros_v);

       
?>
<h2>Lista detalle de vacaciones de</h2>
<h3><?php echo utf8_encode($registro_v[apellido_paterno]." ".$registro_v[apellido_materno]." ".$registro_v[nombres]);?></h3>
</br>
  <a href="#" class="cancelar btn btn-green btn-icon">
      Volver <i class="entypo-back"></i>
  </a>
   <a href="?mod=detalle_vacacion&pag=form_detalle_vacacion&id=<?php echo $id_vacacion;?>" class="btn btn-green btn-icon" style="float: right;  margin-right: 5px;">
        Crear vacaci&oacute;n<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/detalle_vacacion/planilla_detalle_vacacion_pdf.php&id_vacacion=<?php echo $id_vacacion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Imprimir Vacaciones<i class="entypo-print"></i>
    </a>

</h2>
<br /><br /><br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>  
    <th>Nro.</th>
    <th>Gestion inicio</th>
    <th>Gestion fin</th>
    <th>Fecha calculo</th>
    <th>Cantidad dias</th>
    <th>Dias utilizados</th>
    <th>Saldo</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
   
      $registros = $bd->Consulta("select * from detalle_vacacion where id_vacacion=$id_vacacion");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          $saldo = $registro[cantidad_dias] - $registro[dias_utilizados];
          echo "<tr>";        
                    
          echo utf8_encode("<td>$n</td><td>$registro[gestion_inicio]</td><td>$registro[gestion_fin]</td><td>$registro[fecha_calculo]</td><td>$registro[cantidad_dias]</td><td>$registro[dias_utilizados]</td><td>$saldo</td>");
          echo "<td>
                     <a href='?mod=detalle_vacacion&pag=editar_detalle_vacacion&id=$registro[id_detalle_vacacion]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a></br>
                     <a href='control/detalle_vacacion/eliminar.php?id=$registro[id_detalle_vacacion]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                     
                </td>";
          echo "</tr>";
      }   

   
?>
    </tbody>
  <tfoot>                               
  </tfoot>
</table>
</div>

