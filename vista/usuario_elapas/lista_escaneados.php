<?php
	include("modelo/usuario_elapas.php");
   
    $usuario_elapas = new usuario_elapas();
    $registros = $bd->Consulta("select * from usuario_elapas ue inner join expediente e on ue.id_usuario_elapas=e.id_usuario_elapas");
    
?>
<h2>Usuarios ELAPAS</h2> <br>
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Nro Cuenta</th>
            <th>Codigo catastral</th>
			<th>Usuario</th>
            <th>Documento</th>
            <th>Direccion</th>
            <th>Categoria</th>
            <th width='150'>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    while($registro = $bd->getFila($registros))
    {
        $n++;
        echo "<tr>";        
        echo "<td>$n</td>
        <td style='text-align:center;'>$registro[numero_cuenta]</td>
        <td>$registro[codigo_catastral_actual]</td>
        <td>$registro[nombre_usuario]</td>
        <td>$registro[documento]</td>
        <td>$registro[direccion]</td>
        <td>$registro[categoria]</td>";
        echo "<td><a href='?mod=usuario_elapas&pag=editar_usuario_elapas&id=$registro[id_usuario_elapas]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a><br><a href='control/usuario_elapas/eliminar.php?id=$registro[id_usuario_elapas]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a><br><a href='?mod=expediente&pag=lista&id=$registro[id_usuario_elapas]' class='btn btn-green btn-icon btn-xs'>Expedientes<i class='entypo-plus'></i></a></td></tr>";
    }

?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
            <th>Nro Cuenta</th>
            <th>Codigo catastral</th>
			<th>Usuario</th>
            <th>Documento</th>
            <th>Direccion</th>
            <th>Categoria</th>
            <th width='150'>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$usuario_elapas->__destroy();
?>