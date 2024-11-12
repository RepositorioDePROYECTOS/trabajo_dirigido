<?php

include("modelo/solicitud_servicio.php");


$solicitud_servicio = new solicitud_servicio();
$registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
    INNER JOIN usuario u on u.id_usuario=s.id_usuario 
    LEFT JOIN trabajador t on t.id_trabajador=u.id_trabajador 
    LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
    where s.estado_solicitud_servicio='SIN PRESUPUESTO'
    AND s.programa_solicitud_servicio IS NULL
    AND s.actividad_solicitud_servicio IS NULL
    order by s.fecha_solicitud asc");
?>
<h2>
    Lista de Solicitudes de servicio sin Presupuesto
    <a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Solicitudes servicio<i class="entypo-pencil"></i>
    </a>
</h2>

<br><br>
<table class="table table-bordered datatable" id="table-1">
<thead>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina Solicitante</th>
            <th>Item</th>
            <th>Trabajador</th>
            <th>Justificativo</th>
            <th>Autorizado por</th>
            <th>servicio existente</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        while ($registro = $bd->getFila($registros)) {
            echo "<tr>";        ?>

            <td><button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal" data_id="<?php echo $registro[id_solicitud_servicio] . '-servicio' ?>" id="vista" onclick="capturarDataId()"><?php echo $registro[nro_solicitud_servicio] ?></button></td>
        <?php echo utf8_encode("<td>$registro[fecha_solicitud]</td>");
            echo ($registro[oficina_solicitante] != NULL) ? utf8_encode("<td>$registro[oficina_solicitante]</td>") : utf8_encode("<td>$registro[unidad_solicitante]</td>");
            echo utf8_encode("<td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
            echo $registro[existencia_servicio] == 'SI' ? "<td><span class='btn btn-success btn-xs'>SI</span></td>" : "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            if ($registro[estado_solicitud_servicio] == 'SOLICITADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'SIN EXISTENCIA') {
                echo "<td><span class='btn btn-danger btn-xs'>Sin Existencia</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'PRESUPUESTADO') {
                echo "<td><span class='btn btn-green btn-xs'>Presupuestado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'VERIFICADO') {
                echo "<td><span class='btn btn-green btn-xs'>Verificado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "PROVEEDOR ASIGNADO") {
                echo "<td><span class='btn btn-info btn-xs'>Proveedor Asignado</span></td>";
            } 
            elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO RPA") {
                echo "<td><span class='btn btn-info btn-xs'>Visto Bueno RPA</span></td>";
            }
            elseif($registro[estado_solicitud_servicio]=="SIN VISTO BUENO RPA"){
                echo "<td><span class='btn btn-danger btn-xs'>Sin Visto Bueno RPA</span></td>";
            } 
            elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO G.A.") {
                echo "<td><span class='btn btn-info btn-xs'>Visto Bueno <br>GERENTE ADMINISTRATIVO</span></td>";
            }
            elseif ($registro[estado_solicitud_servicio] == "SIN VISTO BUENO G.A.") {
                echo "<td><span class='btn btn-danger btn-xs'>Sin Visto Bueno <br>GERENTE ADMINISTRATIVO</span></td>";
            } 
            elseif ($registro[estado_solicitud_servicio] == "MEMORANDUN") {
                echo "<td><span class='btn btn-info btn-xs'>Memorandun</span></td>";
            } 
            else {
                echo "<td><span class='btn btn-danger btn-xs'>Sin Presupuesto</span></td>";
            }
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
            <th>Autorizado por</th>
            <th>servicio existente</th>
            <th>Estado</th>
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

    function verificar() {
        var boton = event.target;
        var dataId = boton.getAttribute("data_id");
        var partes = dataId.split("-");
        var id_solicitud = partes[0];
        var tipo = partes[1];
        var id_derivacion = partes[2];
        console.log('ID SOL: ' + id_solicitud + " Tipo: " + tipo + " ID DERIVACION: " + id_derivacion);
        document.getElementById('id_solicitud').innerHTML = id_solicitud;
        document.getElementById('id_solicitud').value = id_solicitud;
        document.getElementById('tipo_verificacion').innerHTML = tipo;
        document.getElementById('tipo_verificacion').value = tipo;
        document.getElementById('id_verificaion').innerHTML = id_derivacion;
        document.getElementById('id_verificaion').value = id_derivacion;
    }

    function capturarDataId() {
        var boton = event.target;
        var dataId = boton.getAttribute("data_id");
        var partes = dataId.split("-");
        var id = partes[0];
        var tipo = partes[1];
        // console.log('ID: ' + id + " Tipo: " + tipo);
        fetch('control/derivaciones/buscar.php?id=' + id + '&tipo=' + tipo)
        .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success === true) {
                    console.log(data.detalles);
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
                        const rowClass = (detalle.pruebas_diff > 2) ? 'retraso' : '';
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