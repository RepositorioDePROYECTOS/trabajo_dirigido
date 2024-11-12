<?php
    session_start();
	include("modelo/solicitud_material_ampe.php");
    $id_usuario = $_SESSION[id_usuario];


    $solicitud_material = new solicitud_material_ampe();
    $registros = $bd->Consulta("SELECT * 
        FROM solicitud_material s 
        INNER JOIN usuario u on u.id_usuario=s.id_usuario 
        WHERE u.id_usuario=$id_usuario 
        AND s.objetivo_contratacion='ANPE' 
        ORDER BY s.nro_solicitud_material DESC");  
?>
<h2>Lista de Solicitudes de Materiales </h2><br>
<a href="?mod=solicitud_material&pag=form_solicitud_material_ampe&id_usuario=<?php echo $id_usuario;?>" class="btn btn-green btn-icon" style="float: right;">
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
            <th>Material existente</th>
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
                <td>$registro[nro_solicitud_material]</td>
                <td>".date('d-m-Y', strtotime($registro[fecha_solicitud]))."</td>
                <td>$registro[programa_solicitud_material]</td>
                <td>$registro[actividad_solicitud_material]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>
                <td>$registro[visto_bueno]</td>");
                echo $registro[existencia_material] == 'SI' ? "<td><span class='btn btn-success btn-xs'>SI</span></td>" : "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            if($registro[estado_solicitud_material]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>APROBADO</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='RECHAZADO') {
                echo "<td><span class='btn btn-red btn-xs'>RECHAZADO</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='DESPACHADO') {
                echo "<td><span class='btn btn-green btn-xs'>DESPACHADO</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='SIN EXISTENCIA') {
                echo "<td><span class='btn btn-orange btn-xs'>SIN EXISTENCIA</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='PRESUPUESTADO') {
                echo "<td><span class='btn btn-orange btn-xs'>PRESUPUESTADO</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='ADQUISICION') {
                echo "<td><span class='btn btn-orange btn-xs'>ADQUISICION</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='SIN PRESUPUESTO') {
                echo "<td><span class='btn btn-red btn-xs'>SIN PRESUPUESTO</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>Comprado</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='DESPACHADO SIN EXISTENCIA') {
                echo "<td><span class='btn btn-blue btn-xs'>DESPACHADO <br> SIN EXISTENCIA</span></td>";
            }
            else
                {
                    echo "<td><span class='btn btn-red btn-xs'>ANULADO</span></td>";
                }
                //echo "<td>
                //<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_material/pdf.php&id=$registro[id_solicitud_material]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";

                echo "<td>
                    <a target='_blank' href='vista/solicitud_material/pdf_ampe.php?id=$registro[id_solicitud_material]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
                        if($registro[estado_solicitud_material]=='SOLICITADO')
                        {
                          echo "<a href='control/solicitud_material_ampe/eliminar_ampe.php?id=$registro[id_solicitud_material]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a><br>
                          <a href='?mod=solicitud_material&pag=editar_solicitud_material_ampe&id=$registro[id_solicitud_material]' class='btn btn-orange btn-icon btn-xs' style='float: right; margin-right: 5px;'>Editar <i class='entypo-pencil'></i></a><br>";
                          echo "<a href='?mod=detalle_material&pag=form_detalle_material_ampe&id_solicitud_material=$registro[id_solicitud_material]' class='btn btn-green btn-icon btn-xs' style='float: right;'>
                          A&ntilde;adir material<i class='entypo-plus'></i>
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
            <th>Material existente</th>
            <th>Estado</th>
            <th>Acciones</th>
		</tr>
	</tfoot>
</table>

<?php
	$solicitud_material->__destroy();
?>