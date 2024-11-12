<?php
    session_start();
    $id_usuario = $_SESSION[id_usuario];
	include("modelo/lavado.php");
    $lavado = new lavado();
    $registros = $bd->Consulta("select * from lavado l inner join usuario u on l.id_usuario=u.id_usuario where l.id_usuario=$id_usuario order by l.id_lavado desc");
    
?>
<h2>Mi lista de solicitudes de lavado de vehiculo </h2><br>
<a href="?mod=lavado&pag=form_lavado&id_usuario=<?php echo $id_usuario;?>" class="btn btn-green btn-icon" style="float: right;">
        Crear solicitud<i class="entypo-plus"></i>
    </a>
<br>
<br>
<br>        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Fecha</th>
            <th>Vehiculo</th>
            <th>Placa</th>
			<th>Estado</th>
            <th>Acciones</th>"
		</tr>
	</thead>
	<tbody>
<?php
      
    while($registro = $bd->getFila($registros))
    {
        
        echo "<tr>";        
                   
        echo utf8_encode("<td>$registro[id_lavado]</td><td width='250'>$registro[fecha_solicitud]</td><td style='text-align:center;'>$registro[tipo_vehiculo] $registro[marca_vehiculo]</td><td style='text-align:center;'>$registro[numero_placa]</td><td style='text-align:center;'>$registro[estado_lavado]</td>");
       
        echo "<td width='170'>
            <a target='_blank' href='vista/lavado/pdf.php?id=$registro[id_lavado]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 15px;'>Imprimir<i class='entypo-print'></i></a><br>

            <a href='?mod=lavado&pag=editar_lavado&id=$registro[id_lavado]' class='btn btn-orange btn-icon btn-xs' style='float: right; margin-right: 15px;'>Editar <i class='entypo-pencil'></i></a><br>

            <a href='control/lavado/eliminar.php?id=$registro[id_lavado]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 15px;'>Eliminar <i class='entypo-cancel'></i></a><br>
            
            </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr >
            <th style='text-align:center;'>No</th>
            <th style='text-align:center;'>Fecha</th>
            <th style='text-align:center;'>Vehiculo</th>
			<th style='text-align:center;'>Placa</th>
            <th style='text-align:center;'>Trabajador</th>
            <th style='text-align:center;'>Acciones</th>
        </tr>		
	</tfoot>
</table>
<?php
	$lavado->__destroy();
?>