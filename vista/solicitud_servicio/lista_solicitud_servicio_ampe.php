<?php

	include("modelo/solicitud_servicio_ampe.php");


    $solicitud_servicio = new solicitud_servicio_ampe();
    if($_SESSION[nivel] == 'PRESUPUESTO'){

        $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        inner join trabajador t on t.id_trabajador=u.id_trabajador 
        where s.objetivo_contratacion='ANPE'  
        AND s.estado_solicitud_servicio='APROBADO' order by s.fecha_solicitud asc");  
    }
    elseif($_SESSION[nivel] == 'ADQUISICION'){
        $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        inner join trabajador t on t.id_trabajador=u.id_trabajador 
        where s.objetivo_contratacion='ANPE'  
        AND s.estado_solicitud_servicio='PRESUPUESTADO' order by s.fecha_solicitud asc");  
    }
    else {
        $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        inner join trabajador t on t.id_trabajador=u.id_trabajador 
        where s.objetivo_contratacion='ANPE'  
        AND s.estado_solicitud_servicio='SOLICITADO' order by s.fecha_solicitud asc");  
    }
?>
<h2>Lista de Solicitudes de servicio</h2>
<?php if($_SESSION[nivel] != 'PRESUPUESTO' && $_SESSION[nivel] != 'ADQUISICION' ){ ?>
<a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_aprobado_ampe" class="btn btn-green btn-icon"
    style="float: right;margin-left:5px">
    Aprobados<i class="entypo-plus"></i>
</a>
<a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_rechazado_ampe" class="btn btn-danger btn-icon"
    style="float: right;">
    Rechazados<i class="entypo-plus"></i>
</a>
<?php } ?>

<?php if($_SESSION[nivel] == 'ADQUISICION'){ ?>
<a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_adquisiciones_ampe" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        En adquisiciones<i class="entypo-pencil"></i>
</a>
<?php } ?>
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
        echo "<tr>";        
        
        echo utf8_encode("
                <td>$registro[nro_solicitud_servicio]</td>
                <td>$registro[fecha_solicitud]</td>
                <td>$registro[programa_solicitud_servicio]</td>
                <td>$registro[actividad_solicitud_servicio]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
            if($registro[estado_solicitud_servicio]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio]=='PRESUPUESTADO') {
                echo "<td><span class='btn btn-green btn-xs'>PRESUPUESTADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-danger btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_servicio]=='APROBADO'){
                "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_servicio/papeleta_solicitud_servicio_pdf_ampe.php&id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            }
            echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio_ampe&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
            // echo "<a href='control/solicitud_servicio/aprobar_solicitud.php?id=$registro[id_solicitud_servicio]' class='accion btn btn-green btn-icon' style='float: right; margin-right: 5px;'>Aprobar <i class='entypo-pencil'></i></a><br>";
            // echo "<a href='control/solicitud_servicio/rechazar_solicitud.php?id=$registro[id_solicitud_servicio]' class='accion btn btn-red btn-icon' style='float: right; margin-right: 5px;'>Rechazar<i class='entypo-cancel'></i></a>";
            // echo "</td>";
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
            <th>Autorizado por</th>
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