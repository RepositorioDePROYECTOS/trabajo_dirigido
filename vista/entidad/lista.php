<?php include("modelo/entidad.php");    
    $entidad = new entidad();
    $registros = $bd->Consulta("select * from entidad");    
?>
<h2>Entidad
    <a href="?mod=entidad&pag=form_entidad" class="btn btn-green btn-icon" style="float: right;">
    	Crear Entidad <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
	<th>Nombre entidad</th>
	<th>Ubicacion</th>
	<th>Direccion</th>
	<th>Telefonos</th>
	<th>Correo</th>
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
                  
        echo utf8_encode("	<td>$n</td><td>$registro[nombre_entidad]</td><td>$registro[ubicacion]</td><td>$registro[direccion]</td><td>$registro[telefono]</td><td>$registro[correo]</td>");
        echo "<td>
        	       <a href='?mod=entidad&pag=editar_entidad&id=$registro[id_entidad]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='control/entidad/eliminar.php?id=$registro[id_entidad]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>

