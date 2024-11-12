<?php
	include("modelo/tipo_estante.php");
    
    $tipo_estante = new tipo_estante();
    
    $registros = $tipo_estante->get_all("");
    
?>
<h2>Tipo Estante

    <a href="?mod=tipo_estante&pag=form_tipo_estante" class="btn btn-green btn-icon" style="float: right;">
    	Agregar Tipo Estante
    	<i class="entypo-plus"></i>
    </a>
    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Categoria</th>
            <th>Descripcion</th>
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
            $estado_tipo_estante = "<a href='control/tipo_estante/bloquear.php?id=$registro[id_tipo_estante]' class='accion btn btn-red btn-icon btn-xs'>Bloquear <i class='entypo-cancel'></i></a>";
        else
            $estado_tipo_estante = "<a href='control/tipo_estante/habilitar.php?id=$registro[id_tipo_estante]' class='accion btn btn-green btn-icon btn-xs'>Habilitar <i class='entypo-check'></i></a>";
        
        if($registro[id_tipo_estante] != $_SESSION[id_usuario])
            $eliminar = "<a href='control/tipo_estante/eliminar.php?id=$registro[id_tipo_estante]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
        else
            $eliminar = "";
            
        echo utf8_encode("<td>$n</td><td>$registro[categoria]</td><td>$registro[descripcion]</td>");

    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Categoria</th>
            <th>Descripcion</th>
		</tr>		
	</tfoot>
</table>

<?php
	$tipo_estante->__destroy();
?>