<?php
	include("modelo/expediente.php");
    
    $id_usuario_elapas = $_GET[id];
    $expediente = new expediente();
    
    $registros = $expediente->get_all("id_usuario_elapas=$id_usuario_elapas");
    
?>
<h2>Expedientes

    <a href='?mod=expediente&pag=form_expediente&id=<?php echo $id_usuario_elapas;?>' class='btn btn-green btn-icon' style='float: right;'>
    	Agregar Expediente
    	<i class='entypo-plus'></i>
    </a>
    
</h2>
  
<a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
</a>
  
<br><br /> <br /> 
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Fecha Registro</th>
            <th>Nombre Archivo</th>
            <th>Numero de hojas</th>
            <th>Observacion</th>
            <th>Archivo</th>
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
        echo utf8_encode("<td>$n</td>
                        <td>$registro[fecha_registro]</td>
                        <td>$registro[nombre_archivo]</td>
                        <td>$registro[nro_fojas]</td>
                        <td>$registro[observacion]</td><td>$registro[archivo]</td><td>
        	       <a href='?mod=expediente&pag=archivo&id=$registro[id_expediente]' class='btn btn-warning btn-icon btn-xs'>Visualizar <i class='entypo-eye'></i></a><br> <a href='?mod=expediente&pag=editar_expediente&id=$registro[id_expediente]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a></br>
                   <a href='control/expediente/eliminar.php?id=$registro[id_expediente]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a></td>");
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
            <th>fecha registro</th>
            <th>nombre archivo</th>
            <th>Numero de hojas</th>
			<th>Observaciones</th>
            <th>archivo</th>
            <th>Acciones</th>
		</tr>		
	</tfoot>
</table>

<?php
	$expediente->__destroy();
?>