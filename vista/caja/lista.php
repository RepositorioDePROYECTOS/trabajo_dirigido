<?php
	include("modelo/caja.php");
    $id_fila = $_GET[id_fila];
    $caja = new caja();
    
    $registros = $caja->get_all("");
    
?>
<h2>Caja

    <a href="?mod=caja&pag=form_caja&id_fila=<?php echo $id_fila;?>" class="btn btn-green btn-icon" style="float: right;">
    	Agregar Caja
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Numero caja</th>
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
            $estado_rol = "<a href='control/caja/bloquear.php?id=$registro[id_caja]' class='accion btn btn-red btn-icon btn-xs'>Bloquear <i class='entypo-cancel'></i></a>";
        else
            $estado_rol = "<a href='control/caja/habilitar.php?id=$registro[id_caja]' class='accion btn btn-green btn-icon btn-xs'>Habilitar <i class='entypo-check'></i></a>";
        
        if($registro[id_caja] != $_SESSION[id_usuario])
            $eliminar = "<a href='control/caja/eliminar.php?id=$registro[id_caja]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
        else
            $eliminar = "";
            
        echo utf8_encode("<td>$n</td><td>$registro[nro_caja]</td><td>$registro[estado]</td>");
        echo "<td>
        	       <a href='?mod=caja&pag=editar_caja&id=$registro[id_caja]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   $eliminar
                   
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
			<th>Numero caja</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$caja->__destroy();
?>