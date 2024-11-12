<?php include("modelo/conf_otros_descuentos.php");    
    $conf_otros_descuentos = new conf_otros_descuentos();
    $registros = $bd->Consulta("select * from conf_otros_descuentos");    
?>
<h2>LISTA DE CONFIGURACION DE OTROS DESCUENTOS
    <a href="?mod=conf_otros_descuentos&pag=form_conf_otros_descuentos" class="btn btn-green btn-icon" style="float: right;">
    	Crear otro descuento <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Descripcion</th>
    	<th>Factor calculo</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[descripcion]</td><td>$registro[factor_calculo]</td><td>$registro[estado]</td>");
            echo "<td>
            	       <a href='?mod=conf_otros_descuentos&pag=editar_conf_otros_descuentos&id=$registro[id_conf_otros_descuentos]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_otros_descuentos/eliminar.php?id=$registro[id_conf_otros_descuentos]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    