<?php

	include("modelo/solicitud_material.php");


    $solicitud_material = new solicitud_material();
    $registros = $bd->Consulta("SELECT * FROM solicitud_material s 
    INNER JOIN usuario u ON u.id_usuario=s.id_usuario 
    LEFT join trabajador t ON t.id_trabajador=u.id_trabajador 
    LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
    where s.estado_solicitud_material='ADQUISICION' 
    OR s.estado_solicitud_material='COMPRADO' 
    OR s.estado_solicitud_material='DESPACHADO_SIN_EXISTENCIA'
    ORDER BY s.fecha_solicitud asc");  
?>
<h2>Lista de Solicitudes de Material ADQUISICIONES</h2>
<?php if($_SESSION[nivel] != 'ALMACENERO'){ ?>
<a href="?mod=solicitud_material&pag=lista_solicitud_material" class="btn btn-warning btn-icon" style="float: right;">
        Solicitados<i class="entypo-eye"></i>
</a>
<?php } ?>

<?php if($_SESSION[nivel] == 'ALMACENERO' || $_SESSION[nivel] == 'GERENTE ADMINISTRATIVO'){ ?>
<a href="?mod=solicitud_material&pag=lista_solicitud_material_despachado" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
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
                <td>$registro[nro_solicitud_material]</td>
                <td>".date('d-m-Y', strtotime($registro[fecha_solicitud]))."</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>");
            if($registro[estado_solicitud_material]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='ADQUISICION') {
                echo "<td><span class='btn btn-green btn-xs'>ADQUISICION</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>COMPRADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-cancel btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_material]=='ADQUISICION' || $registro[estado_solicitud_material]=='COMPRADO'){
                echo "<a href='?mod=solicitud_material&pag=detalle_material&id_solicitud_material=$registro[id_solicitud_material]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br><a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_material/pdf.php&id=$registro[id_solicitud_material]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
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
        jQuery('#modal_solicitud_material').modal('show', {
            backdrop: 'static'
        });
        jQuery('#modal_solicitud_material').draggable({
            handle: ".modal-header"
        });
        jQuery("#modal_solicitud_material .modal-body").load(dir, function(res) {
            if (res) {
                var titulo = jQuery('#modal_solicitud_material .modal-body h2').html();
                jQuery('#modal_solicitud_material .modal-body h2').hide();
                jQuery('#modal_solicitud_material .modal-body br').hide();
                jQuery('#modal_solicitud_material .modal-title').html(titulo);
                jQuery('#modal_solicitud_material .modal-body .cancelar').hide();
            }
        });
    });

});
</script>

<?php
	$solicitud_material->__destroy();
?>