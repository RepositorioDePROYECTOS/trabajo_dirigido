<?php
  include("modelo/aguinaldo.php");
  $gestion = $_REQUEST['gestion'];
  $nro_aguinaldo = $_REQUEST['nro_aguinaldo'];
  $aguinaldo = new aguinaldo();
      
  $registros = $bd->Consulta("select * from aguinaldo where gestion=$gestion and nro_aguinaldo=$nro_aguinaldo order by cast(item as unsigned) asc");
  
?>
<a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
</a>
<a href="control/aguinaldo/eliminar_aguinaldo.php?gestion=<?php echo $gestion;?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>

<a href="?mod=aguinaldo&pag=generar_aguinaldo&gestion=<?php echo $gestion;?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Crear planilla<i class="entypo-plus"></i>
</a>

<a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/aguinaldo/reporte_aguinaldo_pdf.php&gestion=<?php echo $gestion;?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Imprimir<i class="entypo-print"></i>
    </a>
  <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/aguinaldo/papeleta_pago_pdf.php&gestion=<?php echo $gestion;?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
      Papeletas de pago<i class="entypo-print"></i>
  </a>
  <?php
  $estados = $bd->Consulta("select * from aguinaldo where gestion=$gestion and nro_aguinaldo=$nro_aguinaldo and estado='APROBADO'");
  $estado = $bd->getFila($estados);
  if(empty($estado))
  {
  ?>
  <a href="control/aguinaldo/aprobar_aguinaldos.php?gestion=<?php echo $gestion; ?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="accion btn btn-green btn-icon" style="float: right; margin-right: 5px;">Aprobar<i class="entypo-pencil"></i></a>
  <?php
  }
  else
  {
  ?>
  <a href="control/aguinaldo/reprobar_aguinaldos.php?gestion=<?php echo $gestion; ?>&nro_aguinaldo=<?php echo $nro_aguinaldo;?>" class="accion btn btn-warning btn-icon" style="float: right; margin-right: 5px;">Reprobar<i class="entypo-pencil"></i></a>
  <?php
  }
  ?>
  
<br />
<h3>
  <strong>PLANILLA:</strong>PLANILLA DE AGUINALDOS ELAPAS<br/>
  <strong>Gesti&oacute;n:</strong><?php echo $gestion;?><br/>
  <strong>N&uacute;mero Aguinaldo:</strong><?php echo $nro_aguinaldo;?><br/>
</h3>
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
  	<th rowspan="2">Item</th>
  	<th rowspan="2">Ci</th>
  	<th rowspan="2">Nombre del empleado</th>
  	<th rowspan="2">Meses</th>
    <th rowspan="2">Dias</th>
    <th rowspan="2">Sexo</th>
  	<th rowspan="2">Cargo que desempena</th>
    <th rowspan="2">Fecha de Ingreso</th>
  	<th colspan="3">Totales ganados</th>
    <th rowspan="2">Total</th>
    <th rowspan="2">Promedio ganado 3 meses</th>
  	<th rowspan="2">Aguinaldo Anual</th>
  	<th rowspan="2">Aguinaldo a pagar</th>
    <th rowspan="2">Estado</th>
    <th width="160" rowspan="2">Acciones</th>
  </tr>
  <tr>
    <th>Sueldo 1 Septiembre</th>
    <th>Sueldo 2 Octubre</th>
    <th>Sueldo 3 Noviembre</th>
  </tr>
</thead>
<tbody>    
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        $n++;
        echo "<tr>";        
        echo "<td>$registro[item]</td><td>$registro[ci]</td><td>".utf8_encode($registro[nombre_empleado])."</td><td>".utf8_encode($registro[meses])."</td><td>".utf8_encode($registro[dias])."</td><td>".utf8_encode($registro[sexo])."</td><td>".utf8_encode($registro[cargo])."</td><td>$registro[fecha_ingreso]</td><td>$registro[sueldo_1]</td><td>$registro[sueldo_2]</td><td>$registro[sueldo_3]</td><td>$registro[total]</td><td>$registro[promedio_3_meses]</td><td>$registro[aguinaldo_anual]</td><td>$registro[aguinaldo_pagar]</td><td>$registro[estado]</td>";
        
        echo "<td>";
        if ($registro[estado_planilla] == 'APROBADO') 
        {
          echo "<a href='control/aguinaldo/reprobar_aguinaldo.php?id=$registro[id_aguinaldo]' class='accion btn btn-warning btn-icon btn-xs'>Reprobar<i class='entypo-pencil'></i></a>";
        }
        else
        {
          echo "<a href='control/aguinaldo/aprobar_aguinaldo.php?id=$registro[id_aguinaldo]' class='accion btn btn-green btn-icon btn-xs'>Aprobar <i class='entypo-pencil'></i></a>";
        }

        echo "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/aguinaldo/papeleta_pago_individual_pdf.php&id=$registro[id_aguinaldo]' class='btn btn-info btn-icon btn-xs'>
                    Papeleta de pago<i class='entypo-print'></i>
                  </a>
                  <a href='?mod=aguinaldo&pag=editar_aguinaldo&id=$registro[id_aguinaldo]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                  <a href='control/aguinaldo/eliminar.php?id=$registro[id_aguinaldo]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    