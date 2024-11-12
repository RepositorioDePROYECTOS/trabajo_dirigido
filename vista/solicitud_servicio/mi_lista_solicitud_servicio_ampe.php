<?php
    session_start();
	include("modelo/solicitud_servicio_ampe.php");
    $id_usuario = $_SESSION[id_usuario];


    $solicitud_servicio = new solicitud_servicio_ampe();
    $registros = $bd->Consulta("SELECT * from solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        where u.id_usuario=$id_usuario 
        AND s.objetivo_contratacion='ANPE' 
        order by s.nro_solicitud_servicio asc");  
?>
<h2>Lista de Solicitudes de servicios </h2></br></br>
<a href="?mod=solicitud_servicio&pag=form_solicitud_servicio_ampe&id_usuario=<?php echo $id_usuario;?>" class="btn btn-green btn-icon" style="float: right;">
        Crear solicitud<i class="entypo-plus"></i>
    </a>
<br><br>
<table class="table table-bordered table-striped datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Fecha solicitud</th>
            <th>Programa</th>
            <th>Actividad</th>
            <th>Oficina</th>
            <th>Justificativo</th>
            <th>Autorizado por</th>
            <th>Visto Bueno</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        echo "<tr>";
                echo utf8_encode("
                <td>$registro[nro_solicitud_servicio]</td>
                <td>".date('d-m-Y', strtotime($registro[fecha_solicitud]))."</td>
                <td>$registro[programa_solicitud_servicio]</td>
                <td>$registro[actividad_solicitud_servicio]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>
                <td>$registro[visto_bueno]</td>");
            if($registro[estado_solicitud_servicio]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='DESPACHADO') {
                echo "<td><span class='btn btn-green btn-xs'>Despachado</span></td>";
            }
            else{
                echo "<td><span class='btn btn-red btn-xs'>Rechazado</span></td>";
            }
                //echo "<td>
                    //<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_servicio/pdf.php&id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
                echo "<td>
                    <a target='_blank' href='vista/solicitud_servicio/pdf_ampe.php?id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";    
                        if($registro[estado_solicitud_servicio]=='SOLICITADO')
                        {
                          echo "<a href='control/solicitud_servicio_ampe/eliminar_ampe.php?id=$registro[id_solicitud_servicio]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a><br>
                          <a href='?mod=solicitud_servicio&pag=editar_solicitud_servicio_ampe&id=$registro[id_solicitud_servicio]' class='btn btn-orange btn-icon btn-xs' style='float: right; margin-right: 5px;'>Editar <i class='entypo-pencil'></i></a><br>";
                          echo "<a href='?mod=detalle_servicio&pag=form_detalle_servicio_ampe&id_solicitud_servicio_ampe=$registro[id_solicitud_servicio]' class='btn btn-green btn-icon btn-xs' style='float: right;'>
                          A&ntilde;adir servicio<i class='entypo-plus'></i>
                      </a>";
                        }
                echo "</td>";
    };	
?>
    </tbody>
	<tfoot>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Programa</th>
            <th>Actividad</th>
            <th>Oficina</th>
            <th>Justificativo</th>
            <th>Autorizado por</th>
            <th>Visto Bueno</th>
            <th>servicio existente</th>
            <th>Estado</th>
		</tr>
	</tfoot>
</table>

<?php
	$solicitud_servicio->__destroy();
?>