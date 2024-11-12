<?php
	include("modelo/ingreso_funcionario.php");


    $ingreso_funcionario = new ingreso_funcionario();
    $registros = $bd->Consulta("select * from ingreso_funcionario i inner join usuario u on u.id_usuario=i.id_usuario order by i.fecha_ingreso asc");  
?>
<h2>Lista de Solicitudes de Ingreso </h2></br></br>
<a href="?mod=ingreso_funcionario&pag=form_ingreso_funcionario" class="btn btn-green btn-icon" style="float: right;">
        Crear ingreso<i class="entypo-plus"></i>
    </a>
        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Fecha solicitud</th>
            <th>Fecha ingreso</th>
            <th>Hora inicio</th>
            <th>Hora fin</th>
            <th>Motivo ingreso</th>
            <th>Observacion</th>
            <th>Autorizado por</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        $registros_t = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador inner join cargo c on ac.id_cargo=c.id_cargo where t.id_trabajador=$registro[autorizado_por]");
        $registro_t = $bd->getFila($registros_t);
        $n++;
        echo "<tr>";

 
                echo utf8_encode("
                <td>$n</td>
                <td>$registro[fecha_registro]</td>
                <td>$registro[fecha_ingreso]</td>
                <td>$registro[hora_inicio]</td>
                <td>$registro[hora_fin]</td>
                <td>$registro[motivo_ingreso]</td>
                <td>$registro[observacion]</td>
                <td>$registro_t[nombres] $registro_t[apellido_paterno] $registro_t[apellido_materno]</td>");
            if($registro[estado_ingreso]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_ingreso]=='AUTORIZADO') {
                echo "<td><span class='btn btn-green btn-xs'>Autorizado</span></td>";
            }
            else{
                echo "<td><span class='btn btn-red btn-xs'>Rechazado</span></td>";
            }
                echo "<td>
                    <a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/ingreso_funcionario/papeleta_ingreso_funcionario_pdf.php&id=$registro[id_ingreso_funcionario]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
                        if($registro[estado_ingreso]=='SOLICITADO')
                        {
                          echo "<a href='control/ingreso_funcionario/eliminar.php?id=$registro[id_ingreso_funcionario]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a>";
                        }
                echo "</td>";
    };	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
            <th>Fecha solicitud</th>
            <th>Fecha ingreso</th>
            <th>Hora inicio</th>
            <th>Hora fin</th>
            <th>Motivo ingreso</th>
            <th>Observacion</th>
            <th>Autorizado por</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>
	</tfoot>
</table>

<?php
	$ingreso_funcionario->__destroy();
?>