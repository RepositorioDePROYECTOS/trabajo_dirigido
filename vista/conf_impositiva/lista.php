<?php include("modelo/conf_impositiva.php");    
    $conf_impositiva = new conf_impositiva();
    $registros = $bd->Consulta("select * from conf_impositiva");    
?>
<h2>CONFIGURACION IMPOSITIVA
    <a href="?mod=conf_impositiva&pag=form_conf_impositiva" class="btn btn-green btn-icon" style="float: right;">
    	Crear impositiva <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Salario minimo</th>
        <th>Cantidad</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[salario_minimo]</td><td>$registro[cant_sm]</td><td>$registro[porcentaje_imp]</td><td>$registro[estado]</td>");
            echo "<td>
            	       <a href='?mod=conf_impositiva&pag=editar_conf_impositiva&id=$registro[id_conf_impositiva]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_impositiva/eliminar.php?id=$registro[id_conf_impositiva]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    