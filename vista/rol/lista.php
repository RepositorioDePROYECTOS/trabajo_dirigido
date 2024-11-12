<?php
	include("modelo/rol.php");
    
    $rol = new rol();
    
    $registros = $rol->get_all("");
    
?>
<h2>Rol

    <a href="?mod=rol&pag=form_rol" class="btn btn-green btn-icon" style="float: right;">
    	Agregar Rol
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nombre</th>
            <th>Estado</th>
            <th width='160'>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    foreach($registros as $key => $registro) 
    {
        $n++;
        echo "<tr>";        
        if($registro[estado_rol]==1)
        {
            $estado_rol = "<a href='control/rol/bloquear.php?id=$registro[id_rol]' class='accion btn btn-red btn-icon btn-xs'>Bloquear <i class='entypo-cancel'></i></a>";
            $estado = 'HABILITADO';
        }
        else
        {
            $estado_rol = "<a href='control/rol/habilitar.php?id=$registro[id_rol]' class='accion btn btn-green btn-icon btn-xs'>Habilitar <i class='entypo-check'></i></a>";
            $estado = 'DESHABILITADO';
        }
        
        if($registro[id_rol] != $_SESSION[id_usuario])
            $eliminar = "<a href='control/rol/eliminar.php?id=$registro[id_rol]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
        else
            $eliminar = "";
            
        echo utf8_encode("<td>$registro[id_rol]</td><td>$registro[nombre_rol]</td><td>$estado</td>");
        echo "<td>
            $estado_rol
            $eliminar
        </td>";
        echo "</tr>";

    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Nombre</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$rol->__destroy();
?>