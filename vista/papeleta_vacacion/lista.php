<?php include("modelo/papeleta_vacacion.php");
    
$id_detalle_vacacion = security($_GET[id]);

$papeleta_vacacion = new papeleta_vacacion();
$registros_v =  $bd->Consulta("select * from detalle_vacacion dv inner join vacacion v on dv.id_vacacion=v.id_vacacion inner join trabajador t on v.id_trabajador=t.id_trabajador where dv.id_detalle_vacacion=$id_detalle_vacacion");
$registro_v = $bd->getFila($registros_v);

       
?>

<table class="table">
  <tr>
    <td colspan="2" align="center"><strong>SOLICITUDES DE VACACIONES</strong></td>
  </tr>
  <tr>
    <td align="right"><strong>Trabajador:</strong></td><td><?php echo $registro_v[apellido_paterno]." ".$registro_v[apellido_materno]." ".$registro_v[nombres];?></td>
  </tr>
  <tr>
    <td align="right"><strong>Periodo de vacaci&oacute;n:</strong></td><td><?php echo $registro_v[gestion_inicio]." al ".$registro_v[gestion_fin];?></td>
  </tr>
  <tr>
    <td align="right"><strong>Total d&iacute;as de vacaci&oacute;n:</strong></td><td><?php echo $registro_v[cantidad_dias];?></td>
  </tr>
</table>
</br>
  <a href="#" class="cancelar btn btn-green btn-icon">
      Volver <i class="entypo-back"></i>
  </a>
   <a href="?mod=papeleta_vacacion&pag=form_papeleta_vacacion&id=<?php echo $id_detalle_vacacion;?>" class="btn btn-green btn-icon" style="float: right;  margin-right: 5px;">
        Solicitar vacaci&oacute;n<i class="entypo-plus"></i>
    </a>
</h2>
<br /><br /><br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>  
    <th rowspan="2">Nro.</th>
    <th rowspan="2">fecha solicitud</th>
    <th colspan="2">Periodo</th>
    <th colspan="2">Fechas</th>
    <th rowspan="2">Dias solicitados</th>
    <th rowspan="2">estado</th>
    <th rowspan="2">autorizado por</th>
    <th rowspan="2">observacion</th>
    <th width="160" rowspan="2">Acciones</th>
  </tr>
  <tr>
    <th>inicio</th>
    <th>fin</th>
    <th>inicio</th>
    <th>fin</th>
  </tr>
</thead>
<tbody>    
<?php
    
   
      $registros = $bd->Consulta("select * from papeleta_vacacion pv inner join detalle_vacacion dv on pv.id_detalle_vacacion=dv.id_detalle_vacacion where pv.id_detalle_vacacion=$id_detalle_vacacion");
      $sum = 0;
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$n</td><td>$registro[fecha_solicitud]</td><td>$registro[gestion_inicio]</td><td>$registro[gestion_fin]</td><td>$registro[fecha_inicio]</td><td>$registro[fecha_fin]</td><td>$registro[dias_solicitados]</td><td>$registro[estado]</td><td>$registro[autorizado_por]</td><td>$registro[observacion]</td>");
          echo "<td>
                     <a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/papeleta_vacacion/papeleta_vacacion_pdf.php&id=$registro[id_papeleta_vacacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>
        Imprimir<i class='entypo-print'></i></a>";
        if($registro[estado]=='SOLICITADO')
        {
          echo "<a href='control/papeleta_vacacion/eliminar.php?id=$registro[id_papeleta_vacacion]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a>";
        }
        echo "</td>";
          echo "</tr>";
          $sum = $sum + $registro[dias_solicitados];
      }
?>
    </tbody>
  <tfoot>
      <tr>
        <td colspan='6' align='right'><strong>TOTAL DIAS SOLICITADOS</strong></td><td><?php echo $sum;?></td><td colspan='4'></td>
      </tr>                       
  </tfoot>
</table>
</div>

