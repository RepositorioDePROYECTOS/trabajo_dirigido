<?php 
    include("modelo/fondo_empleados.php");    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];
    
    $fondo_empleados = new fondo_empleados();
    $registros = $bd->Consulta("select * from fondo_empleados fe inner join asignacion_cargo ac on fe.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='HABILITADO' and fe.mes=$mes and fe.gestion=$gestion order by cast(ac.item as unsigned) asc");    
?>
<h2>FONDO DE EMPLEADOS PERIODO <?php echo $mes;?>/<?php echo $gestion;?><br><br>
    <a href="control/fondo_empleados/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=fondo_empleados&pag=form_fondo_empleados&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-warning btn-icon" style="float: right; margin-right: 5px;">
        Crear FE individual<i class="entypo-plus"></i>
    </a>
    <a href="?mod=fondo_empleados&pag=todos_fondo_empleados&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/fondo_empleados/planilla_fondo_empleados_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla fondo empleados<i class="entypo-print"></i>
    </a>
</h2>
<br>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>  
    <th>Item</th>
    <th>Mes</th>
    <th>Gestion</th>
    <th>Nombre</th>
    <th>Porcentaje</th>
    <th>Total ganado</th>
    <th>Descuento F.E.</th>
    <th>Pago deuda</th>
    <th>Total</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    while($registro = $bd->getFila($registros)) 
    {
        echo "<tr>";        
                  
        echo utf8_encode("  <td>$registro[item]</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[porcentaje_fe]</td><td>$registro[total_ganado]</td><td>$registro[monto_fe]</td><td>$registro[pago_deuda]</td><td>$registro[total_fe]</td>");
        echo "<td>
                   <a href='?mod=fondo_empleados&pag=editar_fondo_empleados&id=$registro[id_fondo_empleados]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='control/fondo_empleados/eliminar.php?id=$registro[id_fondo_empleados]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                   
              </td>";
        echo "</tr>";
    }   
?>
    </tbody>
    <tfoot>                                 
    </tfoot>
</table>
</div>
