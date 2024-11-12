<?php include("modelo/conf_horas_extra.php");    
    $conf_horas_extra = new conf_horas_extra();
    $registros = $bd->Consulta("select * from conf_horas_extra");    
?>
<h2>LISTA DE TIPOS DE HORAS EXTRA
    <a href="?mod=conf_horas_extra&pag=form_conf_horas_extra" class="btn btn-green btn-icon" style="float: right;">
    	Crear tipo hora extra <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Tipo hora extra</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[tipo_he]</td><td>$registro[factor_calculo]</td><td>$registro[estado]</td>");
            echo "<td>
            	       <a href='?mod=conf_horas_extra&pag=editar_conf_horas_extra&id=$registro[id_conf_horas_extra]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_horas_extra/eliminar.php?id=$registro[id_conf_horas_extra]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    