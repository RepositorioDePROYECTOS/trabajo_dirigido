<?php include("modelo/vacacion.php");
    
  $vacacion = new vacacion();
   
  $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");

       
?>
<h2>Lista de vacaciones</h2></br></br>
     <a href="?mod=vacacion&pag=generar_vacaciones" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
      Actualizar Vacaciones<i class="entypo-plus"></i>
    </a>

    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/refrigerio/planilla_refrigerio_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Vacaciones<i class="entypo-print"></i>
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
    <th>Fecha de Ingreso</th>
  	<th>A&ntilde;os</th>
    <th>Meses</th>
    <th>Dias</th>
    <th>D&iacute;as de vacaci&oacute;n</th>
    <th>Vacacion acumulada</th>
    <th>Fecha calculo</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
    while($registro_c = $bd->getFila($registros_c))
    {
      
      $registros = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador left join vacacion v on v.id_trabajador=t.id_trabajador where c.seccion='$registro_c[0]' and ac.estado_asignacion='HABILITADO' order by cast(c.item as unsigned) asc");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$registro[item]</td><td>$registro[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[fecha_ingreso]</td><td>$registro[anios_empresa]</td><td>$registro[meses_empresa]</td><td>$registro[dias_empresa]</td><td>$registro[dias_vacacion]</td><td>$registro[vacacion_acumulada]</td><td>$registro[fecha_calculo]</td>");
          echo "<td>
                     <a href='?mod=vacacion&pag=editar_vacacion&id=$registro[id_vacacion]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a></br><a href='?mod=detalle_vacacion&pag=lista&id=$registro[id_vacacion]' class='btn btn-warning btn-icon btn-xs'>Detalle vacaci&oacute;n <i class='entypo-menu'></i></a>
                     
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

