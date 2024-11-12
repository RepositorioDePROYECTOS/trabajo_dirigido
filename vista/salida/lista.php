<?php
	include("modelo/salida.php");
    include("modelo/rol.php");
    $fecha_i = $_REQUEST['fecha_i'];
    $fecha_f = $_REQUEST['fecha_f'];
    $salida = new salida();
    $registros = $bd->Consulta("select * from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo inner join usuario u on u.id_usuario=s.id_usuario inner join tipo_salida ts on ts.id_tipo_salida=s.id_tipo_salida inner join trabajador t on u.id_trabajador=t.id_trabajador where s.fecha between '$fecha_i' and '$fecha_f' and s.estado=2");
?>
<h2>Lista de Salida Periodo del <?php echo $fecha_i; ?> al <?php echo $fecha_f; ?> </h2></br></br>
<a href="?mod=salida&pag=form_consulta_salida" class="btn btn-danger btn-icon" style="float: left;">
    	Volver
    	<i class="entypo-back"></i>
    </a> <br>
<h2>Salida
    <?php if($_SESSION[nivel] == "GUARDIA SEGURIDAD" || $_SESSION[nivel] == "CONTROL PERSONAL"){ ?>
        <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/salida/planilla_salida_pdf.php&fecha_i=<?php echo $fecha_i; ?>&fecha_f=<?php echo $fecha_f; ?>&estado=2" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Salidas<i class="entypo-print"></i> 
    </a>
        
     <?php } else {?>
        <a href='?mod=salida&pag=form_salida' class='btn btn-green btn-icon' style='float: right;'>
            Agregar Salida
            <i class='entypo-plus'></i>
        </a>
    <?php }?>
    

    
</h2>
<br />  
    
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th width="90px">Fecha</th>
            <th>Hora Salida</th>
            <th>Hora Retorno</th>
            <th>Tiempo Transcurrido</th>
            <th>Direccion de Salida</th>
            <th>Vehiculo</th>
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
            if($registro[id_salida] != $_SESSION[id_usuario])
                $eliminar = "<a href='control/salida/eliminar.php?id=$registro[id_salida]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
            else
                $eliminar = "";
                
                echo utf8_encode("
                <td>$n</td>
                <td >$registro[10]</td>
                <td><b>Solicitada </b>$registro[hora_salida] <br><b>Exacta </b>$registro[hora_e_salida]</td>
                <td><b>Solicitada </b>$registro[hora_retorno]<br><b>Exacta </b>$registro[hora_exac_llegada]</td>
                <td><b>Solicitada </b>$registro[tiempo_solicitado]<br><b>Exacta </b>$registro[tiempo_usado]</td>
                <td>$registro[direccion_salida]</td>
                <td>$registro[18]-$registro[19]</td>
                <td>$registro[24]</td>
                <td>$registro[36]</td>"
            );
            if($registro[15]==0){
                echo "<td><span class='btn btn-orange btn-xs'>Pendiente</span></td>";
            }
            elseif ($registro[15]==1) {
                echo "<td><span class='btn btn-warning btn-xs'>En Proceso</span></td>";
            }
            else{
                echo "<td><span class='btn btn-success btn-xs'>Realizado</span></td>";
            }
    };
?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
			<th >Fecha</th>
            <th>Hora Salida</th>
            <th>Hora Retorno</th>
            <th>Tiempo Transcurrido</th>
            <th>Direccion de Salida</th>
            <th>Vehiculo</th>
            <th>Usuario</th>
            <th>Tipo de Salida</th>
            <th>Estado</th>
		</tr>
	</tfoot>
</table>

<?php
	$salida->__destroy();
?>