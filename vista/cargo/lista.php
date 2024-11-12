<?php include("modelo/cargo.php");    
    $cargo = new cargo();
    $registros = $bd->Consulta("select * from cargo");    
?>
<h2>CARGOS
    <a href="?mod=cargo&pag=form_cargo" class="btn btn-green btn-icon" style="float: right;">
    	Crear Cargo <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Item</th>
    	<th>Nivel</th>
        <th>Seccion</th>
    	<th>Descripcion</th>
    	<th>Salario mensual</th>
    	<th>Estado cargo</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[item]</td><td>$registro[nivel]</td><td>$registro[seccion]</td><td>$registro[descripcion]</td><td>$registro[salario_mensual]</td><td>$registro[estado_cargo]</td>");
            echo "<td>
            	       <a href='?mod=cargo&pag=editar_cargo&id=$registro[id_cargo]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/cargo/eliminar.php?id=$registro[id_cargo]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    