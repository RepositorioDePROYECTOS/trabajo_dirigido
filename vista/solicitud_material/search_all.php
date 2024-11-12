<?php

include("modelo/solicitud_material.php");


$solicitud_material = new solicitud_material();
$registros = $bd->Consulta("SELECT * 
        FROM solicitud_material s 
        INNER JOIN usuario u on u.id_usuario=s.id_usuario 
        INNER JOIN trabajador t on t.id_trabajador=u.id_trabajador 
        INNER JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_material
        -- inner join detalle_material dm on dm.id_solicitud_material = s.id_solicitud_material
        -- inner join requisitos r on r.id_solicitud=s.id_solicitud_material and r.id_derivaciones=d.id_derivacion
        WHERE s.programa_solicitud_material IS NULL
        AND s.actividad_solicitud_material IS NULL
        ORDER BY s.id_solicitud_material DESC");
$tipo_solicitud = "material";
?>
<h2>Lista de Solicitudes de material</h2>
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
            <th>material existente</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        mysql_data_seek($registros, 0);
        while ($registro = $bd->getFila($registros)) {
            echo "<tr>";        ?>
            <td>
                <button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal" data_id="<?php echo $registro[id_solicitud_material] . '-material' ?>" id="vista" onclick="capturarDataId()">
                    <?php echo $registro[nro_solicitud_material] ?>
                </button>
            </td>
            <?php echo utf8_encode("<td>$registro[fecha_solicitud]</td>");
            echo ($registro[oficina_solicitante] != NULL) ?
                utf8_encode("<td>$registro[oficina_solicitante]</td>") :
                utf8_encode("<td>$registro[unidad_solicitante]</td>");
            echo utf8_encode("<td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
            echo $registro[existencia_material] == 'SI' ?
                "<td><span class='btn btn-success btn-xs'>SI</span></td>" :
                "<td><span class='btn btn-danger btn-xs'>NO</span></td>";
            echo "<td><span class='btn btn-info btn-xs'>$registro[estado_solicitud_material]</span></td>";
            ?>
            <td>
                <button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#boton-modal" data_id="<?php echo $registro[id_solicitud_material] . '-material' ?>" id="botones-modal" onclick="getReportes(<?php echo $registro[id_solicitud_material]; ?>)">
                    Generar Reportes
                </button>
            </td>
            </tr>
        <?php
        }
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
            <th>material existente</th>
            <th>Estado</th>
            <th>Acciones</th>
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
                        <p><strong>Numero de Solicitud:</strong></p>
                    </div>
                    <div class="col-sm-8">
                        <p id="nro"></p>
                    </div>
                </div>
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
                <input type="hidden" id="nro_solicitud">
                <div id="tabla-hstoricos">
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
                <button type="button" class="btn btn-primary pull-left" onclick="exportarPDF()">Imprimir Histórico</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="boton-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Vista de la Solicitud content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Cerrar&nbsp;&times;</button>
                <h4 class="modal-title" id="titulo">Reportes</h4>
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
            <div class="modal-body" align="center">
                <a style="width: 450px;" target='_blank' class='letras_boton btn btn-info' id="print_form_1" name="print_form_1">
                    Imprimir
                    <i class='entypo-print'></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-success" id="print_form_5" name="print_form_5">
                    Nota de Adjudicación
                    <i class="entypo-print"></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-info" id="print_form_6" name="print_form_6">
                    Imprimir Orden de Material
                    <i class="entypo-print"></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-success" id="print_form_2" name="print_form_2">
                    Acta conformidad
                    <i class="entypo-print"></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-danger" id="print_form_3" name="print_form_3">
                    Acta no conformidad
                    <i class="entypo-print"></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-warning" id="print_form_4" name="print_form_4">
                    Informe de Adjudicacion
                    <i class="entypo-print"></i>
                </a>
                <br>
                <a style="width: 450px;" target='_blank' class="letras_boton btn btn-success" id="print_form_7" name="print_form_7">
                    Acta de recepci&oacute;n
                    <i class="entypo-print"></i>
                </a>
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

    function getReportes(id) {
        let tipo = "material";
        console.log(id, tipo);
        fetch('control/derivaciones/buscar_solicitud.php?id=' + id + '&tipo=' + tipo)
            .then(response => response.json())
            .then(res => {
                console.log(res);
                const respuesta = res.data;
                const productos = res.guardar; //Tiene los datos finales de la solicitud
                console.log(productos);
                let botones = ["print_form_1", "print_form_5", "print_form_6", "print_form_2", "print_form_3", "print_form_4", "print_form_7"];
                let urls = [];
                console.log(respuesta);
                let timestamp = new Date().getTime(); // obtener el timestamp actual
                urls.push(`vista/solicitud_material/pdf.php?id=${respuesta.id_solicitud_material}&t=${timestamp}`);
                urls.push(`vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=${respuesta.id_solicitud_material}&id_detalle=${respuesta.id_detalle}&tipo=material&t=${timestamp}`);
                urls.push(`vista/derivaciones/pdf.php?id_solicitud=${respuesta.id_solicitud_material}&id_detalle=${respuesta.id_detalle}&tipo=material&t=${timestamp}`);
                if (productos) {
                    urls.push(`vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=${respuesta.id_solicitud_material}&id_detalle=${respuesta.id_detalle_material}&tipo=material&id_requisitos=${respuesta.id_requisitos}&conformidad=si&t=${timestamp}`);
                    urls.push(`vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=${respuesta.id_solicitud_material}&id_detalle=${respuesta.id_detalle}&tipo=material&id_requisitos=${respuesta.id_requisitos}&conformidad=no&t=${timestamp}`);
                    urls.push(`vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=${respuesta.id_solicitud_material}&id_proveedor=${respuesta.id_proveedor}&tipo=material&id_detalle=${respuesta.id_detalle}&t=${timestamp}`);
                    urls.push(`vista/derivaciones/acta_recepcion_pdf.php?id_solicitud=${respuesta.id_solicitud_material}&id_detalle=${respuesta.id_detalle}&tipo=material&id_requisitos=${respuesta.id_requisitos}&aclaracion=Sin Observaciones&t=${timestamp}`);
                }
                console.log(urls);
                for (let i = 0; i < botones.length; i++) {
                    let boton = document.getElementById(botones[i]);
                    if (urls[i] && urls[i] !== "undefined" && urls[i] !== "null" && urls[i] !== "") {
                        boton.href = urls[i];
                        boton.style.display = "block"; // mostrar el botón
                    } else {
                        // boton.href = "#";
                        boton.onclick = function() {
                            alert("Aún no listo");
                        };
                        boton.style.display = "none"; // ocultar el botón
                    }
                }
            })
            .catch(error => console.error(error));
    }

    function capturarDataId() {
        var boton = event.target;
        document.getElementById('nro_solicitud').value = boton.innerText
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
                    console.log(data.detalles);
                    let contador = 1;
                    /* This code is updating the HTML content of certain elements on the page with data retrieved
                    from a server using a fetch request. */
                    document.getElementById('fecha').innerHTML = data.fecha;
                    document.getElementById('derivado_a').innerHTML = decodeURIComponent(data.designado);
                    document.getElementById('nombre').innerHTML = decodeURIComponent(data.nombre);
                    document.getElementById('objetivo').innerHTML = decodeURIComponent(data.objetivo);
                    document.getElementById('justificativo').innerHTML = decodeURIComponent(data.justificativo);
                    document.getElementById('nro').innerHTML = decodeURIComponent(data.nro);
                    document.getElementById('unidad').innerHTML = (data.unidad_solicitante) ? decodeURIComponent(data.unidad_solicitante) : decodeURIComponent(data.oficina_solicitante);
                    let total = 0;
                    let tabla = '<tbody>';
                    data.detalles.forEach(detalle => {
                        tabla += `<tr align='center'>
                                <td>${detalle.id}</td>
                                <td>${decodeURIComponent(detalle.descripcion)}</td>
                                <td>${decodeURIComponent(detalle.unidad_medida)}</td>
                                <td>${decodeURIComponent(detalle.cantidad_solicitada)}</td>`;
                        tabla += `<td>${decodeURIComponent(detalle.precio_unitario)}</td>
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
                                <td>${decodeURIComponent(detalle.tipo_solicitud)}</td>
                                <td>${decodeURIComponent(detalle.fecha)}</td>
                                <td>${decodeURIComponent(detalle.pruebas_diff)}</td>
                                <td>${decodeURIComponent(detalle.responsable)}</td>
                                <td>${decodeURIComponent(detalle.estado)}</td>`;
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

    function estilosImprimir() {
        return `<style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
                .table {
                    width: 100%;
                    margin-bottom: 17px;
                }
                .table-bordered {
                    border: 1px solid #ebebeb;
                }

                .retraso{
                    color: red;
                }

                body{
                    margin: 0;
                    font-size: 9pt;
                    font-family: "Nunito", sans-serif;
                }
                

            </style>`;
    }

    function exportarPDF(nombre, contenedor) {
        let nro_solicitud = document.getElementById('nro_solicitud').value;
        let multa = document.getElementById("tabla-hstoricos").innerHTML;
        console.log(multa);
        let es_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
        let estilos = estilosImprimir();
        if (es_chrome) {
            var iframe = document.createElement("iframe");
            iframe.style.display = "none";
            iframe.srcdoc = estilos + '<html><body> <h2 align="center">REPORTE SEGUIMIENTO SOLICITUD DE material </h2> <h3 align="center">Nro. ' + nro_solicitud + ' </h3>' + multa + '</body></html>';
            // console.log(estilos + '<html><body> <h2 align="center">REPORTE SEGUIMIENTO SOLICITUD DE MATERIAL </h2> <h3 align="center">Nro. </h3>' + multa + '</body>')
            document.body.appendChild(iframe);
            iframe.focus();
            iframe.contentWindow.print();

        } else {
            var win = window.open(multa.innerHTML, "_blank");
            win.focus();
        }

    }
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

<style>
    .retraso {
        background-color: red;
        color: white;
    }

    a.button {
        width: 100%;
    }
</style>

<?php
$solicitud_material->__destroy();
?>