<?php
    session_start();
	include("modelo/solicitud_activo.php");
    $id_usuario = $_SESSION[id_usuario];


    $solicitud_activo = new solicitud_activo();
    $registros = $bd->Consulta("SELECT * from solicitud_activo s 
        INNER JOIN usuario u ON u.id_usuario=s.id_usuario 
        WHERE u.id_usuario=$id_usuario 
        AND s.objetivo_contratacion = 'ANPE' 
        ORDER BY s.nro_solicitud_activo DESC");  
?>
<h2>Lista de Solicitudes de activo </h2><br>
<a href="?mod=solicitud_activo&pag=form_solicitud_activo_ampe&id_usuario=<?php echo $id_usuario;?>" class="btn btn-green btn-icon" style="float: right;">
        Crear solicitud<i class="entypo-plus"></i>
    </a>
<br>
<br>

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
            <th>activo existente</th>
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
                <td>$registro[nro_solicitud_activo]</td>
                <td>".date('d-m-Y', strtotime($registro[fecha_solicitud]))."</td>
                <td>$registro[programa_solicitud_activo]</td>
                <td>$registro[actividad_solicitud_activo]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>
                <td>$registro[visto_bueno]</td>");
                echo $registro[existencia_activo] == 'SI' ? "<td><span class='btn btn-success btn-xs'>SI</span></td>" : "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            if($registro[estado_solicitud_activo]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>APROBADO</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='RECHAZADO') {
                echo "<td><span class='btn btn-red btn-xs'>RECHAZADO</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='DESPACHADO') {
                echo "<td><span class='btn btn-green btn-xs'>DESPACHADO</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='SIN EXISTENCIA') {
                echo "<td><span class='btn btn-orange btn-xs'>SIN EXISTENCIA</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='PRESUPUESTADO') {
                echo "<td><span class='btn btn-orange btn-xs'>PRESUPUESTADO</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='ADQUISICION') {
                echo "<td><span class='btn btn-orange btn-xs'>ADQUISICION</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='SIN PRESUPUESTO') {
                echo "<td><span class='btn btn-red btn-xs'>SIN PRESUPUESTO</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>Comprado</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='DESPACHADO SIN EXISTENCIA') {
                echo "<td><span class='btn btn-blue btn-xs'>DESPACHADO <br> SIN EXISTENCIA</span></td>";
            }
            else
                {
                    echo "<td><span class='btn btn-red btn-xs'>ANULADO</span></td>";
                }
                //echo "<td>
                //<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_activo/pdf.php&id=$registro[id_solicitud_activo]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
                echo "<td>
                    <a target='_blank' href='vista/solicitud_activo/pdf_ampe.php?id=$registro[id_solicitud_activo]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
                        if($registro[estado_solicitud_activo]=='SOLICITADO')
                        {
                          echo "<a href='control/solicitud_activo_ampe/eliminar_ampe.php?id=$registro[id_solicitud_activo]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a><br>
                          <a href='?mod=solicitud_activo&pag=editar_solicitud_activo_ampe&id=$registro[id_solicitud_activo]' class='btn btn-orange btn-icon btn-xs' style='float: right; margin-right: 5px;'>Editar <i class='entypo-pencil'></i></a><br>";
                          echo "<a href='?mod=detalle_activo&pag=form_detalle_activo_ampe&id_solicitud_activo=$registro[id_solicitud_activo]' class='btn btn-green btn-icon btn-xs' style='float: right;'>
                          A&ntilde;adir activo<i class='entypo-plus'></i>
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
            <th>activo existente</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>
	</tfoot>
</table>

<?php
	$solicitud_activo->__destroy();
?>