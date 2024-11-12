<?php include("modelo/conf_aportes.php");    
    $conf_aportes = new conf_aportes();
    $registros = $bd->Consulta("select * from conf_aportes");    
?>
<h2>LISTA DE TIPOS DE APORTE
    <a href="?mod=conf_aportes&pag=form_conf_aportes" class="btn btn-green btn-icon" style="float: right;">
    	Crear aporte <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Tipo Aporte</th>
        <th>Rango inicial</th>
        <th>Rango final</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[tipo_aporte]</td><td>$registro[rango_inicial]</td><td>$registro[rango_final]</td><td>$registro[porc_aporte]</td><td>$registro[estado]</td>");
            echo "<td>
            	       <a href='?mod=conf_aportes&pag=editar_conf_aportes&id=$registro[id_conf_aporte]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_aportes/eliminar.php?id=$registro[id_conf_aporte]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    