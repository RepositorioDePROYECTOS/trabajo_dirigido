<?php include("modelo/detalle_vacacion.php");
    
$id_vacacion = security($_GET[id]);

$detalle_vacacion = new detalle_vacacion();
$registros_v =  $bd->Consulta("select * from vacacion v inner join trabajador t on v.id_trabajador=t.id_trabajador where v.id_vacacion=$id_vacacion");
$registro_v = $bd->getFila($registros_v);

       
?>
<h2>Lista detalle de vacaciones de</h2>
<h3><?php echo $registro_v[apellido_paterno]." ".$registro_v[apellido_materno]." ".$registro_v[nombres];?></h3>
</br>
  <a href="#" class="cancelar btn btn-green btn-icon">
      Volver <i class="entypo-back"></i>
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
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    
   
      $registros = $bd->Consulta("select * from detalle_vacacion where id_vacacion=$id_vacacion");
      while($registro = $bd->getFila($registros)) 
      {
          $n++;
          echo "<tr>";        
                    
          echo utf8_encode("<td>$n</td><td>$registro[gestion_inicio]</td><td>$registro[gestion_fin]</td><td>$registro[fecha_calculo]</td><td>$registro[cantidad_dias]</td><td>$registro[dias_utilizados]</td>");
          echo "<td>
                     <a href='?mod=papeleta_vacacion&pag=lista&id=$registro[id_detalle_vacacion]' class='btn btn-info btn-icon btn-xs'>Solicitudes<i class='entypo-pencil'></i></a>
                     
                </td>";
          echo "</tr>";
      }   

   
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

