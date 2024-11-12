<?php

	include("modelo/solicitud_servicio_ampe.php");


    $solicitud_servicio = new solicitud_servicio_ampe();
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
    inner join usuario u on u.id_usuario=s.id_usuario 
    inner join trabajador t on t.id_trabajador=u.id_trabajador 
    where s.objetivo_contratacion = 'ANPE'
    AND s.estado_solicitud_servicio IN ('ADQUISICION', 'COMPRADO')
    order by s.fecha_solicitud asc");  
?>
<h2>Lista de Solicitudes de servicio en  adquisiciones</h2>

<br>
<table class="table table-bordered table-striped datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Programa</th>
            <th>Actividad</th>
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
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
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[visto_bueno]</td>");
            if($registro[estado_solicitud_servicio]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='ADQUISICION') {
                echo "<td><span class='btn btn-green btn-xs'>ADQUISICION</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>COMPRADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-cancel btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_servicio]=='ADQUISICION' || $registro[estado_solicitud_servicio]=='COMPRADO'){
                echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio_ampe&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>
                <a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_servicio/pdf_ampe.php&id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
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
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
            <th>Visto Bueno</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>

<script>
jQuery(document).ready(function($) {
    jQuery(".view_modal_detail").live("click", function(e) {
        e.preventDefault();
        var param = $(this).attr('href');
        var dir = "modal_index_ajax.php" + param;
        jQuery('#modal_solicitud_servicio').modal('show', {
            backdrop: 'static'
        });
        jQuery('#modal_solicitud_servicio').draggable({
            handle: ".modal-header"
        });
        jQuery("#modal_solicitud_servicio .modal-body").load(dir, function(res) {
            if (res) {
                var titulo = jQuery('#modal_solicitud_servicio .modal-body h2').html();
                jQuery('#modal_solicitud_servicio .modal-body h2').hide();
                jQuery('#modal_solicitud_servicio .modal-body br').hide();
                jQuery('#modal_solicitud_servicio .modal-title').html(titulo);
                jQuery('#modal_solicitud_servicio .modal-body .cancelar').hide();
            }
        });
    });

});
</script>

<?php
	$solicitud_servicio->__destroy();
?>