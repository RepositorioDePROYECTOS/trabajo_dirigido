<?php
	include("modelo/tipo_salida.php");
    
    $tipo_salida = new tipo_salida();
    
    $registros = $tipo_salida->get_all("");
    
?>
<h2>Tipo Salida

    <a href="?mod=tipo_salida&pag=form_tipo_salida" class="btn btn-green btn-icon" style="float: right;">
    	Agregar Tipo Salida
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nombre</th>
            <th>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    foreach($registros as $key => $registro) 
    {
        $n++;
        echo "<tr>";        
            
        echo utf8_encode("<td>$n</td><td>$registro[nombre]</td>");
        echo "<td>
                   $estado_rol<br>
                   <a href='control/tipo_salida/eliminar.php?id=$registro[id_tipo_salida]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
			<th>Codigo</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$tipo_salida->__destroy();
?>