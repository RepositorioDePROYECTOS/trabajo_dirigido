<?php
	include("modelo/fila.php");
    
    $fila = new fila();
    $id_estante = $_GET[id_estante];
    $registros = $fila->get_all("");
    
?>
<h2>Filas

    <a href="?mod=fila&pag=form_fila&id_estante=<?php echo $id_estante;?>" class="btn btn-green btn-icon" style="float: right;">
    	Agregar fila
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Numero fila</th>
            <th>estado</th>
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
        if($registro[estado])
            $estado_rol = "<a href='control/fila/bloquear.php?id=$registro[id_fila]' class='accion btn btn-red btn-icon btn-xs'>Bloquear <i class='entypo-cancel'></i></a>";
        else
            $estado_rol = "<a href='control/fila/habilitar.php?id=$registro[id_fila]' class='accion btn btn-green btn-icon btn-xs'>Habilitar <i class='entypo-check'></i></a>";
        
        if($registro[id_caja] != $_SESSION[id_usuario])
            $eliminar = "<a href='control/fila/eliminar.php?id=$registro[id_caja]' class='accion btn btn-red btn-icon btn-xs'style='float: right; margin-right: 20px;'>Eliminar <i class='entypo-cancel'></i></a>";
        else
            $eliminar = "";
            
        echo utf8_encode("<td>$n</td><td>$registro[nro_fila]</td><td>$registro[estado]</td>");
        echo "<td>
        	       <a href='?mod=lista&pag=editar_fila&id=$registro[id_fila]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 20px;'>Editar <i class='entypo-pencil'></i></a>
                   $eliminar
                   <a href='?mod=caja&pag=lista&id_fila=$registro[id_fila]' class='btn btn-green btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                   A&ntilde;adir cajas<i class='entypo-plus'></i></a>
                   
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
			<th>numero fila</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$fila->__destroy();
?>