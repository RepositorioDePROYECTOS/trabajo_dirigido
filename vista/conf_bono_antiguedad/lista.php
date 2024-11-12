<?php include("modelo/conf_bono_antiguedad.php");    
    $conf_bono_antiguedad = new conf_bono_antiguedad();
    $registros = $bd->Consulta("select * from conf_bono_antiguedad");    
?>
<h2>LISTA DE BONOS DE ANTIGUEDAD
    <a href="?mod=conf_bono_antiguedad&pag=form_conf_bono_antiguedad" class="btn btn-green btn-icon" style="float: right;">
    	Crear bono <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>A&ntilde;o inicio</th>
        <th>A&ntilde;o fin</th>
    	<th>Porcentaje</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[anio_i]</td><td>$registro[anio_f]</td><td>$registro[porcentaje]</td><td>$registro[estado_bono]</td>");
            echo "<td>
            	       <a href='?mod=conf_bono_antiguedad&pag=editar_conf_bono_antiguedad&id=$registro[id_conf_bono_antiguedad]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_bono_antiguedad/eliminar.php?id=$registro[id_conf_bono_antiguedad]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    