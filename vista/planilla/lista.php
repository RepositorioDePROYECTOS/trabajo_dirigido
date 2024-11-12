<?php
  include("modelo/planilla.php");
  include("modelo/nombre_planilla.php");

  $id_nombre_planilla = $_GET[id];

  $nombre_planilla = new nombre_planilla();
  $planilla = new planilla();

  $nombre_planilla->get_nombre_planilla($id_nombre_planilla);
      
  $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla order by cast(item as unsigned) asc");
  
?>
<a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
</a>
<a target="_blank" href="vista/planilla/exportar_csv.php?id_nombre_planilla=<?php echo $id_nombre_planilla;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
        Exportar CSV Ministerio<i class="entypo-export"></i>
</a>
<a href="control/planilla/eliminar_planilla.php?id=<?php echo $id_nombre_planilla;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>

<a href="?mod=planilla&pag=generar_planilla&id=<?php echo $id_nombre_planilla;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Crear planilla<i class="entypo-plus"></i>
</a>

<a target="_blank" href="vista/planilla/planilla_excel.php?id=<?php echo $id_nombre_planilla;?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
        Lista excel <i class="entypo-export"></i>
</a>
<a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/planilla/reporte_planilla_pdf.php&id=<?php echo $id_nombre_planilla; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Imprimir<i class="entypo-print"></i>
    </a>
  <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/planilla/papeleta_pago_pdf.php&id=<?php echo $id_nombre_planilla; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
      Papeletas de pago<i class="entypo-print"></i>
  </a>
  <?php
  $estados = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla and estado_planilla='APROBADO'");
  $estado = $bd->getFila($estados);
  if(empty($estado))
  {
  ?>
  <a href="control/planilla/aprobar_planillas.php?id=<?php echo $id_nombre_planilla; ?>" class="accion btn btn-green btn-icon" style="float: right; margin-right: 5px;">Aprobar<i class="entypo-pencil"></i></a>
  <?php
  }
  else
  {
  ?>
  <a href="control/planilla/reprobar_planillas.php?id=<?php echo $id_nombre_planilla; ?>" class="accion btn btn-warning btn-icon" style="float: right; margin-right: 5px;">Reprobar<i class="entypo-pencil"></i></a>
  <?php
  }
  ?>
  
<br />
<h3>
  <strong>PLANILLA:</strong><?php echo $nombre_planilla->nombre_planilla;?><br/>
  <strong>Gesti&oacute;n:</strong><?php echo $nombre_planilla->gestion;?><br/>
  <strong>Mes:</strong><?php echo $nombre_planilla->mes;?><br/>
</h3>
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
  	<th>Item</th>
  	<th>Ci</th>
    <th>NUA</th>
  	<th>Nombres</th>
  	<th>Apellidos</th>
  	<th>Cargo</th>
  	<th>Fecha ingreso</th>
    <th>Dias pagado</th>
    <th>Haber mensual</th>
    <th>Haber basico</th>
  	<th>Bono antiguedad</th>
  	<th>Horas extra</th>
    <th>Suplencia</th>
  	<th>Total ganado</th>
    <th>Sindicato</th>
  	<th>Categoria Individual</th>
  	<th>Prima riesgo comun</th>
  	<th>Comision al ente</th>
  	<th>Total aporte solidario</th>
  	<th>RCIVA 13%</th>
    <th>Otros descuentos</th>
    <th>Fondo Social</th>
    <th>Fondo empleados</th>
    <th>Entidades financieras</th>
    <th>Total Descuentos</th>
  	<th>Liquido pagable</th>
  	<th>Estado planilla</th>
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
        echo "<td>$n</td><td>$registro[item]</td><td>$registro[ci]</td><td>$registro[nua]</td><td>".utf8_encode($registro[nombres])."</td><td>".utf8_encode($registro[apellidos])."</td><td>".utf8_encode($registro[cargo])."</td><td>$registro[fecha_ingreso]</td><td>$registro[dias_pagado]</td><td>$registro[haber_mensual]</td><td>$registro[haber_basico]</td><td>$registro[bono_antiguedad]</td><td>$registro[horas_extra]</td><td>$registro[suplencia]</td><td>$registro[total_ganado]</td><td>$registro[sindicato]</td><td>$registro[categoria_individual]</td><td>$registro[prima_riesgo_comun]</td><td>$registro[comision_ente]</td><td>$registro[total_aporte_solidario]</td><td>$registro[desc_rciva]</td><td>$registro[otros_descuentos]</td><td>$registro[fondo_social]</td><td>$registro[fondo_empleados]</td><td>$registro[entidades_financieras]</td><td>$registro[total_descuentos]</td><td>$registro[liquido_pagable]</td><td>$registro[estado_planilla]</td>";
        
        echo "<td>";
        if ($registro[estado_planilla] == 'APROBADO') 
        {
          echo "<a href='control/planilla/reprobar_planilla.php?id=$registro[id_planilla]' class='accion btn btn-warning btn-icon btn-xs'>Reprobar<i class='entypo-pencil'></i></a>";
        }
        else
        {
          echo "<a href='control/planilla/aprobar_planilla.php?id=$registro[id_planilla]' class='accion btn btn-green btn-icon btn-xs'>Aprobar <i class='entypo-pencil'></i></a>";
        }

        echo "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/planilla/papeleta_pago_individual_pdf.php&id=$registro[id_planilla]' class='btn btn-info btn-icon btn-xs'>
                    Papeleta de pago<i class='entypo-print'></i>
                  </a>
                  <a href='control/planilla/eliminar.php?id=$registro[id_planilla]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    