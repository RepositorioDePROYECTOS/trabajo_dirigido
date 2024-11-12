<?php
	include("modelo/salida.php");
    include("modelo/rol.php");
    $fecha_i = $_REQUEST['fecha_i'];
    $fecha_f = $_REQUEST['fecha_f'];
    $salida = new salida();
    $estado=0;
    $registros = $bd->Consulta("select * from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo
                                    inner join usuario u on u.id_usuario=s.id_usuario 
                                    inner join tipo_salida ts on ts.id_tipo_salida=s.id_tipo_salida 
                                    inner join trabajador t on u.id_trabajador=t.id_trabajador 
                                    where s.fecha between '$fecha_i' and '$fecha_f' and s.estado=0");    
?>
<h2>Lista de Salida Solicitadas Periodo del <?php echo $fecha_i;?> al <?php echo $fecha_f;?> </h2></br></br>
<a href="?mod=salida&pag=form_consulta_salida" class="btn btn-danger btn-icon" style="float: left;">
    	Volver
    	<i class="entypo-back"></i>
    </a> <br>
<h2>Salida
    
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/salida/planilla_salida_pdf.php&fecha_i=<?php echo $fecha_i; ?>&fecha_f=<?php echo $fecha_f; ?>&estado=<?php echo $estado; ?>" class="btn btn-green btn-icon" style="float: right; margin-right: 5px;">
        REPORTE DE SOLICITUDES<i class="entypo-print"></i> 
    </a>
    

    
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Fecha</th>
            <th>Hora Salida</th>
            <th>Hora exacta de llegada</th>
            <th>Hora Retorno</th>
            <th>Tiempo Solicitado</th>
            <th>Direccion de Salida</th>
            <th>Motivo</th>
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
                
        echo utf8_encode("
        <td>$n</td>
        <td>$registro[fecha]</td>
        <td>$registro[hora_salida]</td>
        <td>$registro[hora_exac_llegada]</td>
        <td>$registro[hora_retorno]</td>
        <td>$registro[tiempo_solicitado]</td>
        <td>$registro[direccion_salida]</td>
        <td>$registro[motivo]</td>
        <td>$registro[14]-$registro[15]</td>
        <td>$registro[19]</td>
        <td>$registro[26]</td>
        <td>$registro[12]</td>"
    );

    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Fecha</th>
            <th>Hora retorno</th>
            <th>Hora exacta de llegada</th>
            <th>Hora salida</th>
            <th>Tiempo Solicitado</th>
            <th>Direccion de Salida</th>
            <th>Motivo</th>
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