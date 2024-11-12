<?php include("modelo/conf_refrigerio.php");    
    $conf_refrigerio = new conf_refrigerio();
    $registros = $bd->Consulta("select * from conf_refrigerio");    
?>
<h2>CONFIGURACION COSTO REFRIGERIO
    <a href="?mod=conf_refrigerio&pag=form_conf_refrigerio" class="btn btn-green btn-icon" style="float: right;">
    	Crear refrigerio <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Descripcion</th>
        <th>Monto Refrigerio</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[descripcion]</td><td>$registro[monto_refrigerio]</td><td>$registro[estado_refrigerio]</td>");
            echo "<td>
            	       <a href='?mod=conf_refrigerio&pag=editar_conf_refrigerio&id=$registro[id_conf_refrigerio]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_refrigerio/eliminar.php?id=$registro[id_conf_refrigerio]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    