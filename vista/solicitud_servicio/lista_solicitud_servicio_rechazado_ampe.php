<?php

	include("modelo/solicitud_servicio_ampe.php");


    $solicitud_servicio = new solicitud_servicio_ampe();
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
    inner join usuario u on u.id_usuario=s.id_usuario 
    inner join trabajador t on t.id_trabajador=u.id_trabajador 
    where s.estado_solicitud_servicio='RECHAZADO'
    AND s.objetivo_contratacion = 'ANPE' 
    order by s.fecha_solicitud asc");  
?>
<h2>Lista de Solicitudes de servicio Rechazado</h2>
<a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_ampe" class="btn btn-warning btn-icon" style="float: right;">
    Solicitados<i class="entypo-pencil"></i>
</a>
<br>
<table class="table table-bordered datatable" id="table-1">
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
                <td>$registro[autorizado_por]</td>
                <td>$registro[visto_bueno]</td>");
            if($registro[estado_solicitud_servicio]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            }
            else{
                echo "<td><span class='btn btn-cancel btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_servicio]=='RECHAZADO'){
                echo "<button class='btn btn-info btn-icon' data-target='#view_modal_obs$registro[id_solicitud_servicio]' data-toggle='modal'
                style='float: right; margin-right: 5px;'>Ver Observación <i class='entypo-eye'></i></button>";
                ?>
                <div class="modal fade" id="view_modal_obs<?=$registro[id_solicitud_servicio]?>" data-backdrop="static">
                    <div class="modal-dialog modal-md" style="margin-top:100px">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="title"><b>Observacion Solicitud de servicio</b></h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <p><b><?= $registro[observacion];?></b></p>
                                    <hr>
                                    <button type="button" class="btn btn-default btn-icon pull-right" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
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