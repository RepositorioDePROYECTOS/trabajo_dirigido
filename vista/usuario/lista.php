<?php
	include("modelo/usuario.php");
    
    $usuario = new usuario();
    
    $registros = $usuario->get_all("");
    
?>
<h2>Usuarios

    <a href="?mod=usuario&pag=form_usuario" class="btn btn-green btn-icon" style="float: right;">
    	Agregar Usuario Item
    	<i class="entypo-plus"></i>
    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p></p>
    <!-- <div style="width: 80px;"></div> -->
    <a href="?mod=usuario&pag=form_usuario_eventual" class="btn btn-info btn-icon" style="float: right;">
    	Agregar Usuario Eventual
    	<i class="entypo-plus"></i>
    </a>
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Correo</th>
            <th>Cuenta</th>
            <th>Nombres y Apellidos</th>
            <th>Nivel</th>
            <th>Fecha &Uacute;ltimo Ingreso</th>
            <th>&Uacute;ltimo Ip</th>
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
        if($registro[estado_usuario])
            $estado_usuario = "<a href='control/usuario/bloquear.php?id=$registro[id_usuario]' class='accion btn btn-red btn-icon btn-xs'>Bloquear <i class='entypo-cancel'></i></a>";
        else
            $estado_usuario = "<a href='control/usuario/habilitar.php?id=$registro[id_usuario]' class='accion btn btn-green btn-icon btn-xs'>Habilitar <i class='entypo-check'></i></a>";
        
        if($registro[id_usuario] != $_SESSION[id_usuario])
            $eliminar = "<a href='control/usuario/eliminar.php?id=$registro[id_usuario]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
        else
            $eliminar = "";
            
        echo utf8_encode("<td>$n</td><td>$registro[correo]</td><td>$registro[cuenta]</td><td>$registro[nombre_apellidos]</td><td>$registro[nivel]</td><td>$registro[fecha_ultimo_ingreso]</td><td>$registro[ip_ultimo]</td>");
        echo "<td>
        	       <a href='?mod=usuario&pag=editar_usuario&id=$registro[id_usuario]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   $eliminar
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Correo</th>
            <th>Cuenta</th>
            <th>Nombres y Apellidos</th>
            <th>Nivel</th>            
            <th>Fecha &Uacute;ltimo Ingreso</th>
            <th>&Uacute;ltimo Ip</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$usuario->__destroy();
?>