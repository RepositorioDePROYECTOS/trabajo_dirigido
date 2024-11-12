<?php
	include("modelo/salida.php");
    include("modelo/rol.php");
    $fecha_actual = date("Y-m-d");
    $salida = new salida();
    $registros = $bd->Consulta("select * from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo
                                    inner join usuario u on u.id_usuario=s.id_usuario 
                                    inner join tipo_salida ts on ts.id_tipo_salida=s.id_tipo_salida 
                                    inner join trabajador t on u.id_trabajador=t.id_trabajador 
                                    where s.fecha='$fecha_actual' and s.estado=1");    
?>
<h2>Trabajadores en Salida</h2></br></br>
 <br>
<h2>Salida
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Usuario</th>
            <th>Tipo de Salida</th>
            <th>Estado</th>
        </tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        $n++;
        echo "<tr>";        
        

            // if($registro[id_salida] != $_SESSION[id_usuario])
            //     $eliminar = "<a href='control/salida/eliminar.php?id=$registro[id_salida]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
            // else
            //     $eliminar = "";
                
                echo utf8_encode("
                <td>$n</td>
                <td>$registro[31]</td>
                <td>$registro[27]</td>"
                );
                if($registro[13]==0){
                    echo "<td><span class='btn btn-orange btn-xs'>Pendiente</span></td>";
                }
                elseif ($registro[13]==1) {
                    echo "<td><span class='btn btn-warning btn-xs'>En Proceso</span></td>";
                }
                else{
                    echo "<td><span class='btn btn-success btn-xs'>Realizado</span></td>";
                }
    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
            <th>Usuario</th>
            <th>Tipo de Salida</th>
            <th>Estado</th>
            </tr>
	</tfoot>
</table>

<?php
	$salida->__destroy();
?>