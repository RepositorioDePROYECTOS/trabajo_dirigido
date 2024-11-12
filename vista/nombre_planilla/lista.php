<?php include("modelo/nombre_planilla.php");    
    $nombre_planilla = new nombre_planilla();
    $registros = $bd->Consulta("select * from nombre_planilla order by id_nombre_planilla desc");    
?>
<h2>Planillas
    <a href="?mod=nombre_planilla&pag=form_nombre_planilla" class="btn btn-green btn-icon" style="float: right;">
    	Crear planilla <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
	<th>Mes</th>
	<th>Gesti&oacute;n</th>
	<th>Nombre planilla</th>
	<th>Fecha creaci&oacute;n</th>
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
                  
        echo utf8_encode("	<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[nombre_planilla]</td><td>$registro[fecha_creacion]</td><td>$registro[estado]</td>");
        echo "<td>
        	       <!--<a href='?mod=nombre_planilla&pag=editar_nombre_planilla&id=$registro[id_nombre_planilla]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a></br>-->
                   <a href='control/nombre_planilla/eliminar.php?id=$registro[id_nombre_planilla]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a></br><a href='?mod=planilla&pag=lista&id=$registro[id_nombre_planilla]' class='btn btn-success btn-icon btn-xs'>Cargar Planilla <i class='entypo-menu'></i></a></br><a href='?mod=planilla&pag=resumen&id=$registro[id_nombre_planilla]' class='btn btn-warning btn-icon btn-xs'>Resumen Planilla <i class='entypo-menu'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    