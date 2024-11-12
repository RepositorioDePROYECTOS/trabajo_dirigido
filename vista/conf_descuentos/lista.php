<?php include("modelo/conf_descuentos.php");    
    $conf_descuentos = new conf_descuentos();
    $registros = $bd->Consulta("select * from conf_descuentos");    
?>
<h2>LISTA DE DESCUENTOS
    <a href="?mod=conf_descuentos&pag=form_conf_descuentos" class="btn btn-green btn-icon" style="float: right;">
    	Crear descuenta <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Nombre descuento</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[nombre_descuento]</td><td>$registro[estado]</td>");
            echo "<td>
            	       <a href='?mod=conf_descuentos&pag=editar_conf_descuentos&id=$registro[id_conf_descuentos]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_descuentos/eliminar.php?id=$registro[id_conf_descuentos]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    