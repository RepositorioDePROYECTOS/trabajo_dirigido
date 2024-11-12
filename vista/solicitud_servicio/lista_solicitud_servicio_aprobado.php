<?php

include("modelo/solicitud_servicio.php");


$solicitud_servicio = new solicitud_servicio();
$registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
    inner join usuario u on u.id_usuario=s.id_usuario 
    LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
    LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
    LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
    where s.estado_solicitud_servicio='APROBADO' 
    AND s.programa_solicitud_servicio IS NULL
    AND s.actividad_solicitud_servicio IS NULL
    order by s.fecha_solicitud asc");
?>
<h2>Lista de Solicitudes de servicio Aprobados</h2>
<?php if ($_SESSION[nivel] != 'ALMACENERO') { ?>
    <a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio" class="btn btn-warning btn-icon" style="float: right;">
        Solicitados<i class="entypo-eye"></i>
    </a>
<?php } ?>

<br>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
            <th>Estado</th>
            <!-- <th>Acciones</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        while ($registro = $bd->getFila($registros)) {
            echo "<tr>";?>
            <td><button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal" data_id="<?php echo $registro[id_solicitud_servicio] . '-servicio' ?>" id="vista" onclick="capturarDataId()"><?php echo $registro[nro_solicitud_servicio] ?></button></td>
            
            <?php echo utf8_encode("<td>" . date('d-m-Y', strtotime($registro[fecha_solicitud])) . "</td>
                <td>$registro[oficina_solicitante]</td>
                <td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>");
            if ($registro[estado_solicitud_servicio] == 'SOLICITADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'COMPRADO') {
                echo "<td><span class='btn btn-blue btn-xs'>Comprado</span></td>";
            } else {
                echo "<td><span class='btn btn-cancel btn-xs'>Rechazado</span></td>";
            }
            // echo "<td>";
            // if ($registro[estado_solicitud_servicio] == 'APROBADO' || $registro[estado_solicitud_servicio] == 'COMPRADO') {
            //     echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
            //     if($registro[id_derivacion]){
            //         echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
            //     }
            // }
            // echo "</td>";
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
            <!-- <th>Acciones</th> -->
        </tr>
    </tfoot>
</table>

<!-- Vista de la Solicitud -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Vista de la Solicitud content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Trabajador Solicitante:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="nombre"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Unidad Solicitante:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="unidad"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Objetivo:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="objetivo"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Justificativo:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="justificativo"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Fecha de Derivacion:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="fecha"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="text-align: right;">
                        <p><strong>Derivado a:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="derivado_a"></p>
                    </div>
                </div>

                <div>
                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripcion</th>
                                <th>Unidad De Medida</th>
                                <th>Cantidad Solicitada</th>
                                <div id="precio_u" style="display: none;">
                                    <th>Precio Unitario</th>
                                    <th>Precio Total</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody id="tabla_detalle">

                        </tbody>
                    </table>
                </div>
                <p id="total" style="text-align: right;"></p>
                <div>
                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Solicitud</th>
                                <th>Fecha de Atencion</th>
                                <th>Dias Demorados</th>
                                <th>Atentido Por</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_historicos">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script>
    const formatoMoneda = new Intl.NumberFormat('es-BO', {
        style: 'currency',
        currency: 'BOB'
    });

    function capturarDataId() {
        var boton = event.target;
        var dataId = boton.getAttribute("data_id");
        var partes = dataId.split("-");
        var id = partes[0];
        var tipo = partes[1];
        console.log('ID: ' + id + " Tipo: " + tipo);
        fetch('control/derivaciones/buscar.php?id=' + id + '&tipo=' + tipo)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success === true) {
                    console.log(data.id_d_trabajador);
                    let contador = 1;
                    /* This code is updating the HTML content of certain elements on the page with data retrieved
                    from a server using a fetch request. */
                    document.getElementById('fecha').innerHTML = data.fecha;
                    document.getElementById('derivado_a').innerHTML = data.designado;
                    document.getElementById('nombre').innerHTML = data.nombre;
                    document.getElementById('objetivo').innerHTML = data.objetivo;
                    document.getElementById('justificativo').innerHTML = data.justificativo;
                    document.getElementById('unidad').innerHTML = (data.unidad_solicitante) ? data.unidad_solicitante : data.oficina_solicitante;
                    let total = 0;
                    let tabla = '<tbody>';
                    data.detalles.forEach(detalle => {
                        tabla += `<tr align='center'>
                                <td>${detalle.id}</td>
                                <td>${detalle.descripcion}</td>
                                <td>${detalle.unidad_medida}</td>
                                <td>${detalle.cantidad_solicitada}</td>`;
                        tabla += `<td>${detalle.precio_unitario}</td>
                    <td>${detalle.precio_total}</td>`;
                        total = parseFloat(total) + parseFloat(detalle.precio_total);
                        tabla += `</tr>`;
                    });
                    tabla += '</tbody>';
                    document.getElementById('tabla_detalle').innerHTML = tabla;
                    document.getElementById('total').innerHTML = formatoMoneda.format(total);


                    let tabla2 = '<tbody>';
                    data.info.forEach(detalle => {
                        const rowClass = (detalle.retraso == "si") ? 'retraso' : '';
                        tabla2 += `<tr align='center' class='${rowClass}'>
                                <td>${contador}</td>
                                <td>${detalle.tipo_solicitud}</td>
                                <td>${detalle.fecha}</td>
                                <td>${detalle.pruebas_diff}</td>
                                <td>${detalle.responsable}</td>
                                <td>${detalle.estado}</td>`;
                        tabla2 += `</tr>`;
                        // fecha_pasada = fecha_cercana;
                        contador++;
                    })
                    tabla2 += '</tbody>';
                    document.getElementById('tabla_historicos').innerHTML = tabla2;
                }
            })
            .catch(error => console.error(error));
    }

    function calcularDiferenciaEnDias(fecha1, fecha2) {
        const unDiaEnMilisegundos = 24 * 60 * 60 * 1000;
        const fecha1EnMilisegundos = fecha1.getTime();
        const fecha2EnMilisegundos = fecha2.getTime();
        const diferenciaEnMilisegundos = fecha2EnMilisegundos - fecha1EnMilisegundos;
        const dias = Math.round(diferenciaEnMilisegundos / unDiaEnMilisegundos);
        return dias;
    }
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

<style>
    .retraso {
        background-color: red;
        color: white;
    }
</style>

<?php
$solicitud_servicio->__destroy();
?>