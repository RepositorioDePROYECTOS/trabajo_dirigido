<?php 
  
  session_start();

  include("modelo/vacacion.php");
    
  $vacacion = new vacacion();
  $id_usuario = $_SESSION[id_usuario];

   
  $registros_c = $bd->Consulta("select * from usuario where id_usuario=$id_usuario");
  
  $registro_c = $bd->getFila($registros_c);
  // echo "Datos" . $registro_c[id_trabajador];
       
?>
<h2>Mis vacaciones</h2></br></br>
     
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/refrigerio/planilla_refrigerio_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Mis Vacaciones<i class="entypo-print"></i>
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
    
    $registros = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador left join vacacion v on v.id_trabajador=t.id_trabajador where v.id_trabajador=$registro_c[id_trabajador] and ac.estado_asignacion='HABILITADO'");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$registro[item]</td><td>$registro[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[fecha_ingreso]</td><td>$registro[anios_empresa]</td><td>$registro[meses_empresa]</td><td>$registro[dias_empresa]</td><td>$registro[dias_vacacion]</td><td>$registro[vacacion_acumulada]</td><td>$registro[fecha_calculo]</td>");
          echo "<td>
                     <a href='?mod=detalle_vacacion&pag=lista_mis_vacaciones&id=$registro[id_vacacion]' class='btn btn-warning btn-icon btn-xs'>Detalle vacaci&oacute;n <i class='entypo-menu'></i></a>
                     
                </td>";
          echo "</tr>";
      }   


   
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

