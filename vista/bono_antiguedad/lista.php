<?php 
    include("modelo/bono_antiguedad.php");    
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];
    
    $bono_antiguedad = new bono_antiguedad();
    $registros = $bd->Consulta("select * from bono_antiguedad ba inner join asignacion_cargo ac on ba.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where ba.mes=$mes and ba.gestion=$gestion");    
?>
<h2>BONOS DE ANTIGUEDAD PERIODO <?php echo $mes;?>/<?php echo $gestion;?><br><br>
    <a href="control/bono_antiguedad/eliminar_planilla.php?mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="accion btn btn-red btn-icon" style="float: right; margin-right: 5px;">Eliminar Planilla<i class="entypo-cancel"></i></a>
    <a href="?mod=bono_antiguedad&pag=form_bono_antiguedad&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-green btn-icon" style="float: right;  margin-right: 5px;">
        Crear bono individual<i class="entypo-plus"></i>
    </a>
    <a href="?mod=bono_antiguedad&pag=todos_bono_antiguedad&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/bono_antiguedad/planilla_bono_antiguedad_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla bono antiguedad<i class="entypo-print"></i>
    </a>
</h2>
<br>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>  
    <th>No</th>
    <th>Mes</th>
    <th>Gestion</th>
    <th>Nombre</th>
    <th>Ant. otras inst.</th>
    <th>Fecha ingreso</th>
    <th>Fecha calculo</th>
    <th>Antiguedad</th>
    <th>Porcentaje</th>
    <th>Total bono</th>
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
                  
        echo utf8_encode("  <td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[anios_arrastre] a&ntilde;os<br>$registro[meses_arrastre] meses<br>$registro[dias_arrastre] d&iacute;as</td><td>$registro[fecha_ingreso]</td><td>$registro[fecha_calculo]</td><td>$registro[anios] a&ntilde;os<br>$registro[meses] meses<br>$registro[dias] d&iacute;as</td><td>$registro[porcentaje]</td><td>$registro[monto]</td>");
        echo "<td>
                   <a href='?mod=bono_antiguedad&pag=editar_bono_antiguedad&id=$registro[id_bono_antiguedad]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='control/bono_antiguedad/eliminar.php?id=$registro[id_bono_antiguedad]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
              </td>";
        echo "</tr>";
    }   
?>
    </tbody>
    <tfoot>                                 
    </tfoot>
</table>
</div>
