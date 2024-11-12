<?php

	include("modelo/solicitud_material_ampe.php");


    $solicitud_material = new solicitud_material_ampe();
    if($_SESSION[nivel] == 'PRESUPUESTO'){

        $registros = $bd->Consulta("SELECT * 
            FROM solicitud_material s 
            INNER JOIN usuario u on u.id_usuario=s.id_usuario 
            LEFT JOIN trabajador t on t.id_trabajador=u.id_trabajador 
            LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
            WHERE s.objetivo_contratacion = 'ANPE'
            AND s.estado_solicitud_material IN ('SIN EXISTENCIA') 
            AND s.existencia_material='NO' 
            ORDER BY s.id_solicitud_material DESC");  
    }
    elseif($_SESSION[nivel] == 'ADQUISICION'){
        $registros = $bd->Consulta("SELECT * 
            FROM solicitud_material s 
            INNER JOIN usuario u on u.id_usuario=s.id_usuario 
            LEFT JOIN trabajador t on t.id_trabajador=u.id_trabajador 
            LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
            WHERE s.objetivo_contratacion = 'ANPE'
            AND s.estado_solicitud_material IN ('PRESUPUESTADO') 
            AND s.existencia_material='NO' 
            ORDER BY s.id_solicitud_material DESC");  
    }
    else {
        $registros = $bd->Consulta("SELECT * 
            FROM solicitud_material s 
            INNER JOIN usuario u on u.id_usuario=s.id_usuario 
            LEFT JOIN trabajador t on t.id_trabajador=u.id_trabajador 
            LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
            WHERE s.objetivo_contratacion = 'ANPE'
            AND s.estado_solicitud_material IN ('SOLICITADO') 
            ORDER BY s.id_solicitud_material DESC");  
    }
?>
<h2>Lista de Solicitudes de Material</h2>
<?php if($_SESSION[nivel] != 'PRESUPUESTO' && $_SESSION[nivel] != 'ADQUISICION' ){ ?>
<a href="?mod=solicitud_material&pag=lista_solicitud_material_aprobado_ampe" class="btn btn-green btn-icon"
    style="float: right;margin-left:5px">
    Aprobados<i class="entypo-plus"></i>
</a>
<a href="?mod=solicitud_material&pag=lista_solicitud_material_rechazado_ampe" class="btn btn-danger btn-icon"
    style="float: right;">
    Rechazados<i class="entypo-plus"></i>
</a>
<?php } ?>
<?php if($_SESSION[nivel] == 'ALMACENERO' || $_SESSION[nivel] == 'GERENTE ADMINISTRATIVO'){ ?>
<a href="?mod=solicitud_material&pag=lista_solicitud_material_despachado_ampe" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Despachados<i class="entypo-pencil"></i>
</a>
<?php } ?>

<?php if($_SESSION[nivel] == 'ADQUISICION'){ ?>
<a href="?mod=solicitud_material&pag=lista_solicitud_material_adquisiciones_ampe" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
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
                <td>$registro[fecha_solicitud]</td>
                <td>$registro[programa_solicitud_material]</td>
                <td>$registro[actividad_solicitud_material]</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
                echo $registro[existencia_material] == 'SI' ? "<td><span class='btn btn-success btn-xs'>SI</span></td>" : "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            if($registro[estado_solicitud_material]=='SOLICITADO'){
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='SIN EXISTENCIA') {
                echo "<td><span class='btn btn-danger btn-xs'>SIN EXISTENCIA</span></td>";
            }
            elseif ($registro[estado_solicitud_material]=='PRESUPUESTADO') {
                echo "<td><span class='btn btn-green btn-xs'>PRESUPUESTADO</span></td>";
            }
            else{
                echo "<td><span class='btn btn-danger btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if($registro[estado_solicitud_material]=='APROBADO'){
                "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_material/papeleta_solicitud_material_pdf_ampe.php&id=$registro[id_solicitud_material]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            }
            echo "<a href='?mod=solicitud_material&pag=detalle_material_ampe&id_solicitud_material=$registro[id_solicitud_material]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
            // echo "<a href='control/solicitud_material/aprobar_solicitud.php?id=$registro[id_solicitud_material]' class='accion btn btn-green btn-icon' style='float: right; margin-right: 5px;'>Aprobar <i class='entypo-pencil'></i></a><br>";
            // echo "<a href='control/solicitud_material/rechazar_solicitud.php?id=$registro[id_solicitud_material]' class='accion btn btn-red btn-icon' style='float: right; margin-right: 5px;'>Rechazar<i class='entypo-cancel'></i></a>";
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
            <th>Material existente</th>
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