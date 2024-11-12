<?php include("modelo/eventual.php");    
    $trabajador = new eventual();
    $registros = $bd->Consulta("select * from eventual");    
?>
<h2>TRABAJADORES EVENTUALES
    <a href="?mod=eventual&pag=form_eventual" class="btn btn-green btn-icon" style="float: right;">
    	Crear Trabajador<i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
	<th>Nombres</th>
    <th>Apellido Paterno</th>
	<th>Apellido Materno</th>
	<th>Item</th>
    <th>Nivel</th>
	<th>Cargo</th>
	<th>Seccion/th>
	<th>Salario Mensual</th>
	<th>Estado</th>
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
                  
        echo utf8_encode("	<td>$n</td><td>$registro[nombres]</td><td>$registro[apellido_paterno]</td><td>$registro[apellido_materno]</td><td>$registro[item]</td><td>$registro[nivel]</td><td>$registro[descripcion]</td><td>$registro[seccion]</td><td>$registro[salario_mensual]</td><td>$registro[estado_eventual]</td>");
        echo "<td>
        	       <a href='?mod=eventual&pag=editar_eventual&id=$registro[0]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='control/eventual/eliminar.php?id=$registro[0]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

