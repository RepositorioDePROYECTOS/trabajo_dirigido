<?php

	include("modelo/solicitud_activo.php");


    $solicitud_activo = new solicitud_activo();
    $registros = $bd->Consulta("SELECT * FROM solicitud_activo s 
    inner join usuario u on u.id_usuario=s.id_usuario 
    LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
    LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
    where s.estado_solicitud_activo='ADQUISICION' 
    or s.estado_solicitud_activo='COMPRADO' 
    OR s.estado_solicitud_activo='DESPACHADO_SIN_EXISTENCIA'
    order by s.fecha_solicitud asc");  
?>
<h2>Lista de Solicitudes de activo ADQUISICIONES</h2>
<?php if($_SESSION[nivel] != 'ACTIVOS'){ ?>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo" class="btn btn-warning btn-icon" style="float: right;">
        Solicitados<i class="entypo-eye"></i>
</a>
<?php } ?>

<?php if($_SESSION[nivel] == 'ACTIVOS' || $_SESSION[nivel] == 'GERENTE ADMINISTRATIVO'){ ?>
<a href="?mod=solicitud_activo&pag=lista_solicitud_activo_despachado" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Despachados<i class="entypo-eye"></i>
</a>
<?php } ?>
<br><br>
<table class="table table-bordered table-striped datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
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
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>");
            if($registro[estado_solicitud_activo]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='ADQUISICION') {
                echo "<td><span class='btn btn-green btn-xs'>ADQUISICION</span></td>";
            }
            elseif ($registro[estado_solicitud_activo]=='COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>COMPRADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-cancel btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_activo]=='ADQUISICION' || $registro[estado_solicitud_activo]=='COMPRADO'){
                echo "<a href='?mod=solicitud_activo&pag=detalle_activo&id_solicitud_activo=$registro[id_solicitud_activo]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br><a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_activo/pdf.php&id=$registro[id_solicitud_activo]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            }
           echo "</td>";
           
    };	
?>
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
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