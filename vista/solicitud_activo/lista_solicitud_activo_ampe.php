<?php

	include("modelo/solicitud_activo_ampe.php");


    $solicitud_activo = new solicitud_activo_ampe();
    if($_SESSION[nivel] == 'PRESUPUESTO'){

        $registros = $bd->Consulta("SELECT * FROM solicitud_activo s
            INNER JOIN usuario u ON u.id_usuario = s.id_usuario
            INNER JOIN trabajador t ON t.id_trabajador = u.id_trabajador
            WHERE s.objetivo_contratacion = 'ANPE'
            AND s.estado_solicitud_activo = 'SIN EXISTENCIA' 
            AND s.existencia_activo = 'NO' 
            ORDER BY s.id_solicitud_activo DESC");  
    }
    elseif($_SESSION[nivel] == 'ADQUISICION'){
        $registros = $bd->Consulta("SELECT * FROM solicitud_activo s 
        INNER JOIN usuario u ON u.id_usuario = s.id_usuario 
        INNER JOIN trabajador t ON t.id_trabajador = u.id_trabajador 
        WHERE s.objetivo_contratacion = 'ANPE' 
        AND s.estado_solicitud_activo = 'PRESUPUESTADO' 
        AND s.existencia_activo = 'NO' 
        ORDER BY s.id_solicitud_activo DESC");  
    }
    else {
        $registros = $bd->Consulta("SELECT * FROM solicitud_activo s 
        INNER JOIN usuario u on u.id_usuario=s.id_usuario 
        INNER JOIN trabajador t on t.id_trabajador=u.id_trabajador 
        WHERE s.objetivo_contratacion = 'ANPE'
        AND S.estado_solicitud_activo='SOLICITADO' 
        ORDER BY s.id_solicitud_activo DESC");  
    }
?>
<h2>Lista de Solicitudes de activo</h2>
<?php if($_SESSION[nivel] != 'PRESUPUESTO' && $_SESSION[nivel] != 'ADQUISICION' ){ ?>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo_aprobado_ampe" class="btn btn-green btn-icon"
    style="float: right;margin-left:5px">
    Aprobados<i class="entypo-plus"></i>
</a>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo_rechazado_ampe" class="btn btn-danger btn-icon"
    style="float: right;">
    Rechazados<i class="entypo-plus"></i>
</a>
<?php } ?>
<?php if($_SESSION[nivel] == 'ACTIVOS' || $_SESSION[nivel] == 'GERENTE ADMINISTRATIVO'){ ?>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo_despachado_ampe" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Despachados<i class="entypo-pencil"></i>
</a>
<?php } ?>

<?php if($_SESSION[nivel] == 'ADQUISICION'){ ?>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo_adquisiciones_ampe" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        En adquisiciones<i class="entypo-pencil"></i>
</a>
<?php } ?>
<br>
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
                <td>$registro[fecha_solicitud]</td>
                <td>$registro[programa_solicitud_activo]</td>
                <td>$registro[actividad_solicitud_activo]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
                echo $registro[existencia_activo] == 'SI' ? "<td><span class='btn btn-success btn-xs'>SI</span></td>" : "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            if($registro[estado_solicitud_activo]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='SIN EXISTENCIA') {
                echo "<td><span class='btn btn-danger btn-xs'>SIN EXISTENCIA</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='PRESUPUESTADO') {
                echo "<td><span class='btn btn-green btn-xs'>PRESUPUESTADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-danger btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_activo]=='APROBADO'){
                "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_activo/papeleta_solicitud_activo_pdf.php&id=$registro[id_solicitud_activo]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            }
            echo "<a href='?mod=solicitud_activo&pag=detalle_activo_ampe&id_solicitud_activo=$registro[id_solicitud_activo]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
            // echo "<a href='control/solicitud_activo/aprobar_solicitud.php?id=$registro[id_solicitud_activo]' class='accion btn btn-green btn-icon' style='float: right; margin-right: 5px;'>Aprobar <i class='entypo-pencil'></i></a><br>";
            // echo "<a href='control/solicitud_activo/rechazar_solicitud.php?id=$registro[id_solicitud_activo]' class='accion btn btn-red btn-icon' style='float: right; margin-right: 5px;'>Rechazar<i class='entypo-cancel'></i></a>";
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
            <th>activo existente</th>
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
        jQuery('#modal_solicitud_activo').modal('show', {
            backdrop: 'static'
        });
        jQuery('#modal_solicitud_activo').draggable({
            handle: ".modal-header"
        });
        jQuery("#modal_solicitud_activo .modal-body").load(dir, function(res) {
            if (res) {
                var titulo = jQuery('#modal_solicitud_activo .modal-body h2').html();
                jQuery('#modal_solicitud_activo .modal-body h2').hide();
                jQuery('#modal_solicitud_activo .modal-body br').hide();
                jQuery('#modal_solicitud_activo .modal-title').html(titulo);
                jQuery('#modal_solicitud_activo .modal-body .cancelar').hide();
            }
        });
    });

});
</script>

<?php
	$solicitud_activo->__destroy();
?>