<?php

include("modelo/solicitud_servicio.php");


$solicitud_servicio = new solicitud_servicio();
if ($_SESSION[nivel] == 'PRESUPUESTO') {

    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where s.estado_solicitud_servicio='VERIFICADO' 
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        order by s.id_solicitud_servicio DESC");
} elseif ($_SESSION[nivel] == 'ADQUISICION') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where s.estado_solicitud_servicio='APROBADO' 
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        order by s.id_solicitud_servicio DESC");
} elseif ($_SESSION[nivel] == 'GERENTE GENERAL') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where ( s.estado_solicitud_servicio='VERIFICADO' 
        OR s.estado_solicitud_servicio='SOLICITADO' 
        OR s.estado_solicitud_servicio='PRESUPUESTADO' )
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        order by s.id_solicitud_servicio desc");
} elseif ($_SESSION[nivel] == 'GERENTE TECNICO') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        INNER JOIN asignacion_cargo as ac ON ac.id_trabajador = t.id_trabajador
        INNER JOIN cargo as c ON c.id_cargo=ac.id_cargo
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where ( s.estado_solicitud_servicio='VERIFICADO' 
        OR s.estado_solicitud_servicio='SOLICITADO' 
        OR s.estado_solicitud_servicio='PRESUPUESTADO' )
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        AND c.seccion = 'GERENCIA TECNICA'
        order by s.id_solicitud_servicio desc");
} elseif ($_SESSION[nivel] == 'GERENTE COMERCIAL') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        INNER JOIN asignacion_cargo as ac ON ac.id_trabajador = t.id_trabajador
        INNER JOIN cargo as c ON c.id_cargo=ac.id_cargo
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where ( s.estado_solicitud_servicio='VERIFICADO' 
        OR s.estado_solicitud_servicio='SOLICITADO' 
        OR s.estado_solicitud_servicio='PRESUPUESTADO' )
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        AND c.seccion = 'GERENCIA COMERCIAL'
        order by s.id_solicitud_servicio desc");
} elseif ($_SESSION[nivel] == 'GERENTE ADMINISTRATIVO') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where ( s.estado_solicitud_servicio='SOLICITADO' 
        OR s.estado_solicitud_servicio='VERIFICADO' 
        OR s.estado_solicitud_servicio='PRESUPUESTADO' )
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        order by s.id_solicitud_servicio DESC");
} elseif ($_SESSION[nivel] == 'RPA') {
    $registros = $bd->Consulta("SELECT * FROM solicitud_servicio s 
        inner join usuario u on u.id_usuario=s.id_usuario 
        LEFT join trabajador t on t.id_trabajador=u.id_trabajador 
        LEFT JOIN eventual e ON e.id_eventual = u.id_eventual
        LEFT JOIN derivaciones as d ON d.id_solicitud = s.id_solicitud_servicio
        where s.estado_solicitud_servicio='MEMORANDUN'
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL
        order by s.id_solicitud_servicio DESC");
}
?>
<h2>Lista de Solicitudes de Servicio con Memorandun</h2>
<?php if ($_SESSION[nivel] != 'PRESUPUESTO' && $_SESSION[nivel] != 'ADQUISICION') { ?>
    <a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_aprobado" class="btn btn-green btn-icon" style="float: right;margin-left:5px">
        Aprobados<i class="entypo-plus"></i>
    </a>
    <a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_rechazado" class="btn btn-danger btn-icon" style="float: right;">
        Rechazados<i class="entypo-plus"></i>
    </a>
<?php } ?>

<?php if ($_SESSION[nivel] == 'ADQUISICION') { ?>
    <a href="?mod=solicitud_servicio&pag=lista_solicitud_servicio_adquisiciones" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        En adquisiciones<i class="entypo-pencil"></i>
    </a>
<?php } ?>
<?php if ($_SESSION[nivel] == 'PRESUPUESTO') { ?>
    <a href="?mod=solicitud_servicio&pag=lista_presupuestados" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Presupuestados<i class="entypo-pencil"></i>
    </a>
    <a href="?mod=solicitud_servicio&pag=lista_sin_presupuesto" class="btn btn-danger btn-icon" style="float: right;margin-right: 5px;">
        Sin Presupuesto<i class="entypo-pencil"></i>
    </a>
<?php } ?>
<?php if ($_SESSION[nivel] != 'PRESUPUESTO') { ?>
    <div class="btn-group " role="group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrar por estado
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" style="font-size: 12pt;">
            <a class="dropdown-item" href="?mod=solicitud_servicio&pag=lista_solicitud_servicio">Solicitudes</a> <br>
            <?php if ($_SESSION[nivel] != 'GERENTE ADMINISTRATIVO') { ?>
                <a class="dropdown-item" href="?mod=solicitud_servicio&pag=lista_proveedor_asignado">Proveedor Asignado</a> <br>
            <?php } ?>
            <a class="dropdown-item" href="?mod=solicitud_servicio&pag=lista_con_visto_bueno">Con Visto Bueno</a> <br>
            <a class="dropdown-item" href="?mod=solicitud_servicio&pag=lista_sin_visto_bueno">Sin Visto Bueno</a> <br>
            <?php if ($_SESSION[nivel] == 'RPA') { ?>
                <a class="dropdown-item" href="?mod=solicitud_servicio&pag=lista_memorandun">Memorandun</a> <br>
            <?php } ?>
        </ul>
    </div>
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
            <th>Autorizado por</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        while ($registro = $bd->getFila($registros)) {
            echo "<tr>";  ?>
            <td><button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal" data_id="<?php echo $registro[id_solicitud_servicio] . '-servicio' ?>" id="vista" onclick="capturarDataId()"><?php echo $registro[nro_solicitud_servicio] ?></button></td>
        <?php echo utf8_encode("<td>$registro[id_solicitud_servicio]</td>");
            echo ($registro[oficina_solicitante] != NULL) ? utf8_encode("<td>$registro[oficina_solicitante]</td>") : utf8_encode("<td>$registro[unidad_solicitante]</td>");
            echo utf8_encode("<td>$registro[item_solicitante]</td>
                <td>$registro[nombre_solicitante]</td>
                <td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
            if ($registro[estado_solicitud_servicio] == 'SOLICITADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'VERIFICADO') {
                echo "<td><span class='btn btn-warning btn-xs'>Verificado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'PRESUPUESTADO') {
                echo "<td><span class='btn btn-green btn-xs'>Presupuestado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "PROVEEDOR ASIGNADO") {
                echo "<td><span class='btn btn-info btn-xs'>Provador Asignado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO RPA") {
                echo "<td><span class='btn btn-info btn-xs'>Visto Bueno RPA</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "SIN VISTO BUENO RPA") {
                echo "<td><span class='btn btn-danger btn-xs'>Sin Visto Bueno RPA</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO G.A.") {
                echo "<td><span class='btn btn-info btn-xs'>Visto Bueno <br>GERENTE ADMINISTRATIVO</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "SIN VISTO BUENO G.A.") {
                echo "<td><span class='btn btn-danger btn-xs'>SIN VISTO BUENO <br>GERENTE ADMINISTRATIVO</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == "MEMORANDUN") {
                echo "<td><span class='btn btn-info btn-xs'>Memorandun</span></td>";
            } else {
                echo "<td><span class='btn btn-danger btn-xs'>Rechazado</span></td>";
            }
            echo "<td>";
            if ($registro[estado_solicitud_servicio] == 'APROBADO') {
                "<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_servicio/papeleta_solicitud_servicio_pdf.php&id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            }

            // echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
            if ($registro[id_derivacion] != NULL) {
                // echo "NIVEL: ".$_SESSION[nivel];
                // echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                if ($_SESSION[nivel] == "RPA") {
                    // echo "ENTRO AL RPA<br>";
                    // echo "ESTADO: ".$registro[estado_solicitud_servicio]."<br>";
                    if ($registro[estado_solicitud_servicio] == 'PRESUPUESTADO') {
                        echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
                    } else {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    }
                }
                if ($_SESSION[nivel] == "ADQUISICION") {
                    // echo "ESTADO: ".$registro[estado_solicitud_servicio];
                    if ($registro[estado_solicitud_servicio] == "APROBADO") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } elseif ($registro[estado_solicitud_servicio] == "PROVEEDOR ASIGNADO") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO RPA") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } elseif ($registro[estado_solicitud_servicio] == " SIN VISTO BUENO RPA" || $registro[estado_solicitud_servicio] == " SIN VISTO BUENO G.A.") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } elseif ($registro[estado_solicitud_servicio] == "VISTO BUENO G.A.") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } else {
                        echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
                    }
                }
                if ($_SESSION[nivel] == "GERENTE ADMINISTRATIVO") {
                    // echo $registro[estado_solicitud_servicio];
                    if ($registro[estado_solicitud_servicio] == "APROBADO") {
                        echo "<a href='?mod=derivaciones&pag=orden_compra&id=$registro[id_derivacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>Atender Solicitud&nbsp;<i class='entypo-plus'></i></a>";
                    } else {
                        // echo "SIN".$registro[estado_solicitud_servicio];
                        echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
                    }
                }
                if ($_SESSION[nivel] == "GERENTE GENERAL" || $_SESSION[nivel] == "GERENTE TECNICO" || $_SESSION[nivel] == "GERENTE COMERCIAL") {
                    echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Ver detalle <i class='entypo-eye'></i></a><br>";
                }
                if ($_SESSION[nivel] == "PRESUPUESTO") {
                    echo "<a href='?mod=solicitud_servicio&pag=detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon view_modal_detail' style='float: right; margin-right: 5px;'>Certificar <i class='entypo-eye'></i></a><br>";
                }
            } else {
                echo "<a class='btn btn-danger btn-icon' style='float: right; margin-right: 5px;'>No se derivo <br>la Solicitud&nbsp;<i class='entypo-back'></i></a>";
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
        document.getElementById('nro_solicitud').value = boton.innerText
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
                        const rowClass = (detalle.pruebas_diff > 2) ? 'retraso' : '';
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
        console.log(nro_solicitud)
        let multa = document.getElementById("tabla-hstoricos").innerHTML;
        console.log(multa);
        let es_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
        let estilos = estilosImprimir();
        if (es_chrome) {
            var iframe = document.createElement("iframe");
            iframe.style.display = "none";
            iframe.srcdoc = estilos + '<html><body> <h2 align="center">REPORTE SEGUIMIENTO SOLICITUD DE SERVICIO </h2> <h3 align="center">Nro. '+ nro_solicitud +' </h3>' + multa + '</body></html>';
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