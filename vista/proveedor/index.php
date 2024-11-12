<?php
	include("modelo/proveedor.php");
    
    $proveedor = new proveedor();
    
    $registros = $proveedor->get_all("");
    
?>
<h2>proveedor

    <a href="?mod=proveedor&pag=create" class="btn btn-green btn-icon" style="float: right;">
    	Agregar proveedor
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nombre</th>
            <th>Nit</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Celular</th>
            <th>Observacion</th>
            <th width='160'>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    foreach($registros as $registro) 
    {
        $n++;
        echo "<tr>";   
            echo "<td>$n</td>";     
            
            echo "<td>";
            echo utf8_encode($registro[nombre]);
            echo "</td>";

            echo "<td>";
            echo utf8_encode($registro[nit]);
            echo "</td>";
            
            echo "<td>";
            echo utf8_encode($registro[direccion]);
            echo "</td>";
            
            echo "<td>";
            echo utf8_encode($registro[telefono]);
            echo "</td>";
            
            echo "<td>";
            echo utf8_encode($registro[celular]);
            echo "</td>";
            
            echo "<td>";
            echo utf8_encode($registro[observacion]);
            echo "</td>";
            
            echo "<td>";
            echo "<a href='?mod=proveedor&pag=edit&id=$registro[id_proveedor]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
            echo "<a href='control/proveedor/delete.php?id=$registro[id_proveedor]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
            echo "</td>";
        
            echo "</tr>";

    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Nombre</th>
            <th>Nit</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Celular</th>
            <th>Observacion</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$proveedor->__destroy();
?>