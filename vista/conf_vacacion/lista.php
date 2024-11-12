<?php include("modelo/conf_vacacion.php");    
    $conf_vacacion = new conf_vacacion();
    $registros = $bd->Consulta("select * from conf_vacacion");    
?>
<h2>LISTA DE DIAS DE VACACION POR ANTIGUEDAD
    <a href="?mod=conf_vacacion&pag=form_conf_vacacion" class="btn btn-green btn-icon" style="float: right;">
    	Crear vacacion<i class="entypo-plus"></i>
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
        <th>Dias de vacacion</th>
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
                      
            echo utf8_encode("	<td>$n</td><td>$registro[anio_inicio]</td><td>$registro[anio_fin]</td><td>$registro[dias_vacacion]</td><td>$registro[estado_vaca]</td>");
            echo "<td>
            	       <a href='?mod=conf_vacacion&pag=editar_conf_vacacion&id=$registro[id_conf_vacacion]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/conf_vacacion/eliminar.php?id=$registro[id_conf_vacacion]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
          		  </td>";
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    