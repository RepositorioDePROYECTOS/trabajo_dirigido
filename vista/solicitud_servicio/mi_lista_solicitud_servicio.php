<?php
session_start();
include("modelo/solicitud_servicio.php");
$id_usuario = $_SESSION[id_usuario];
// echo $id_usuario;


$solicitud_servicio = new solicitud_servicio();
$registros = $bd->Consulta("SELECT * 
    from solicitud_servicio s 
    inner join usuario u on u.id_usuario=s.id_usuario 
    where u.id_usuario=$id_usuario 
    AND s.programa_solicitud_servicio IS NULL
    AND s.actividad_solicitud_servicio IS NULL
    order by s.id_solicitud_servicio DESC");
?>
<h2>Lista de Solicitudes de servicios </h2></br></br>
<a href="?mod=solicitud_servicio&pag=form_solicitud_servicio&id_usuario=<?php echo $id_usuario; ?>" class="btn btn-green btn-icon" style="float: right;">
    Crear solicitud<i class="entypo-plus"></i>
</a>
<br><br>
<table class="table table-bordered table-striped datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina</th>
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
            echo "<tr>";
            echo utf8_encode("
                <td>$registro[nro_solicitud_servicio]</td>
                <td>" . date('d-m-Y', strtotime($registro[fecha_solicitud])) . "</td>");
            echo ($registro[oficina_solicitante] != NULL) ? utf8_encode("<td>$registro[oficina_solicitante]</td>") : utf8_encode("<td>$registro[unidad_solicitante]</td>");
            echo utf8_encode("<td>$registro[justificativo]</td>
                <td>$registro[autorizado_por]</td>");
            if ($registro[estado_solicitud_servicio] == 'SOLICITADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Solicitado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'APROBADO') {
                echo "<td><span class='btn btn-green btn-xs'>Aprobado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'DESPACHADO') {
                echo "<td><span class='btn btn-green btn-xs'>Despachado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'PRESUPUESTADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Presupuestado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'VERIFICADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Verificado</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'VISTO BUENO RPA') {
                echo "<td><span class='btn btn-orange btn-xs'>Visto Bueno RPA</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'SIN VISTO BUENO RPA') {
                echo "<td><span class='btn btn-orange btn-xs'>Sin Visto Bueno RPA</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'VISTO BUENO G.A.') {
                echo "<td><span class='btn btn-orange btn-xs'>Visto Bueno <br> Gerente Administrativo</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'SIN VISTO BUENO G.A.') {
                echo "<td><span class='btn btn-orange btn-xs'>Sin Visto Bueno <br> Gerente Administrativo</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'MEMORANDUN') {
                echo "<td><span class='btn btn-info btn-xs'>MEMORANDUN</span></td>";
            } elseif ($registro[estado_solicitud_servicio] == 'PROVEEDOR ASIGNADO') {
                echo "<td><span class='btn btn-orange btn-xs'>Proveedor Asignado</span></td>";
            } else {
                echo "<td><span class='btn btn-red btn-xs'>Rechazado</span></td>";
            }
            //echo "<td>
                
            //<a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/solicitud_servicio/pdf.php&id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            echo "<td>
                
                <a target='_blank' href='vista/solicitud_servicio/pdf.php?id=$registro[id_solicitud_servicio]' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Imprimir<i class='entypo-print'></i></a><br>";
            if (
                $registro[estado_solicitud_servicio] == 'SOLICITADO' || $registro[estado_solicitud_servicio] == 'PRESUPUESTADO'
                || $registro[estado_solicitud_servicio] == 'VERIFICADO' || $registro[estado_solicitud_servicio] == 'APROBADO'
                || $registro[estado_solicitud_servicio] == 'VISTO BUENO RPA' || $registro[estado_solicitud_servicio] == 'SIN VISTO BUENO RPA' || $registro[estado_solicitud_servicio] == 'PROVEEDOR ASIGNADO'
                || $registro[estado_solicitud_servicio] == 'VISTO BUENO G.A.' || $registro[estado_solicitud_servicio] == 'SIN VISTO BUENO G.A.' || $registro[estado_solicitud_servicio] == 'MEMORANDUN'
            ) {
                $derivacion = $bd->Consulta("SELECT estado_derivacion FROM derivaciones WHERE id_solicitud=$registro[id_solicitud_servicio]");
                // echo "SELECT estado_derivacion FROM derivaciones WHERE id_solicitud=$registro[id_solicitud_servicio]";
                $derivar = $bd->getFila($derivacion);

                if ($derivar == FALSE) {
                    echo "<a href='control/solicitud_servicio/eliminar.php?id=$registro[id_solicitud_servicio]' class='accion btn btn-red btn-icon btn-xs' style='float: right; margin-right: 5px;'>Eliminar <i class='entypo-cancel'></i></a><br>"; // ELIMINAR
                    echo "<a href='?mod=solicitud_servicio&pag=editar_solicitud_servicio&id=$registro[id_solicitud_servicio]' class='btn btn-orange btn-icon btn-xs' style='float: right; margin-right: 5px;'>Editar <i class='entypo-pencil'></i></a><br>"; // EDITAR
                    echo "<a href='?mod=detalle_servicio&pag=form_detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-green btn-icon btn-xs' style='float: right; margin-right: 5px;'>A&ntilde;adir servicio<i class='entypo-plus'></i></a><br>"; // AÑADIR
                    // echo "<a href='?mod=derivaciones&pag=form_derivaciones&id=$registro[id_solicitud_servicio]&tipo=servicio' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Derivar <i class='entypo-plus'></i></a>"; // DERIVAR

                    $detalle_servicios = $bd->Consulta("SELECT * 
                            FROM detalle_servicio as da 
                            INNER JOIN especificaciones_servicio as ea ON ea.id_detalle_servicio = da.id_detalle_servicio
                            WHERE da.id_solicitud_servicio  = $registro[id_solicitud_servicio]");
                    $detalle_servicio = $bd->getFila($detalle_servicios);
                    if ($detalle_servicio) {
                        echo "<a href='?mod=derivaciones&pag=form_derivaciones&id=$registro[id_solicitud_servicio]&tipo=servicio' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Derivar <i class='entypo-plus'></i></a>"; // DERIVAR
                    }
                } elseif ($derivar == TRUE) {
                    echo "<button type='button' class='btn btn-info btn-icon btn-xs' data_id='$registro[id_solicitud_servicio]-servicio' data-toggle='modal' data-target='#myModal' style='float: right; margin-right: 5px;' onclick='capturarDataId()'>Seguimiento<i class='entypo-search'></i></button> <br>";
                    if ($derivar[estado_derivacion] == 'solicitar') {
                        echo "<a href='?mod=detalle_servicio&pag=form_detalle_servicio&id_solicitud_servicio=$registro[id_solicitud_servicio]' class='btn btn-green btn-icon btn-xs' style='float: right; margin-right: 5px;'> A&ntilde;adir servicio<i class='entypo-plus'></i></a>";
                        echo "<a href='?mod=derivaciones&pag=form_derivaciones&id=$registro[id_solicitud_servicio]&tipo=servicio' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Derivar <i class='entypo-plus'></i></a><br>";
                    } elseif ($derivar[estado_derivacion] == 'solicitado') {
                        // echo "<a href='?mod=derivaciones&pag=form_derivaciones&id=$registro[id_solicitud_servicio]&tipo=material' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>Derivado <i class='entypo-plus'></i></a><br>";
                        // echo "<button type='button' class='btn btn-info btn-icon btn-xs' data_id='$registro[id_solicitud_servicio]-servicio' data-toggle='modal' data-target='#myModal' style='float: right; margin-right: 5px;' onclick='capturarDataId()'>Seguimiento<i class='entypo-search'></i></button> <br>";
                    } elseif ($derivar[estado_derivacion] == 'verificado') {
                        // echo "<a class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 5px;'>verificado <i class='entypo-check'></i></a>";
                        // echo "<button type='button' class='btn btn-info btn-icon btn-xs' data_id='$registro[id_solicitud_servicio]-servicio' data-toggle='modal' data-target='#myModal' style='float: right; margin-right: 5px;' onclick='capturarDataId()'>Seguimiento<i class='entypo-search'></i></button> <br>";
                    } elseif ($derivar[estado_derivacion] == 'presupuestado') {
                        // echo "<button type='button' class='btn btn-info btn-icon btn-xs' data_id='$registro[id_solicitud_servicio]-servicio' data-toggle='modal' data-target='#myModal' style='float: right; margin-right: 5px;' onclick='capturarDataId()'>Seguimiento<i class='entypo-search'></i></button> <br>";
                    }
                }
            }
            echo "</td>";
        };
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Fecha solicitud</th>
            <th>Oficina</th>
            <th>Justificativo</th>
            <th>Autorizado por</th>
            <th>servicio existente</th>
            <th>Estado</th>
        </tr>
    </tfoot>
</table>
<div id="mostrar_modal"></div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Seguimiento de la Solicitud
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                                <th>Siguiente por Atender</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_historicos">

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
$solicitud_servicio->__destroy();
?>
<script type="text/javascript">
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
                    document.getElementById('fecha').innerHTML = decodeURIComponent(data.fecha);
                    document.getElementById('derivado_a').innerHTML = decodeURIComponent(data.designado);
                    document.getElementById('nombre').innerHTML = decodeURIComponent(data.nombre);
                    document.getElementById('objetivo').innerHTML = decodeURIComponent(data.objetivo);
                    document.getElementById('justificativo').innerHTML = decodeURIComponent(data.justificativo);
                    document.getElementById('nro').innerHTML = decodeURIComponent(data.nro);
                    document.getElementById('unidad').innerHTML = (data.unidad_solicitante) ? decodeURIComponent(data.unidad_solicitante) : decodeURIComponent(data.oficina_solicitante);
                    let total = 0;
                    let siguiente = "";
                    let nommbre_responsable = "";
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
                        if (detalle.estado === 'SOLICITADO' || detalle.estado === 'solicitado') {
                            if (detalle.tipo_solicitud === 'MATERIAL' || detalle.tipo_solicitud === 'material') {
                                nommbre_responsable = "PERCY EDUARDO ALCOCER ZAMORA";
                            } else if (detalle.tipo_solicitud === 'MATERIAL' || detalle.tipo_solicitud === 'material') {
                                nommbre_responsable = "EDWIN ZAMBRANA GONZALES";
                            } else {
                                nommbre_responsable = "PERSONAL DESIGNADO";
                            }
                            siguiente = nommbre_responsable;
                        } else if (detalle.estado === 'VERIFICADO' || detalle.estado === 'verificado') {
                            siguiente = "JOSUE BENITO LUNA MUÑOZ";
                        } else if (detalle.estado === 'PRESUPUESTADO' || detalle.estado === 'presupuestado') {
                            siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                        } else if (detalle.estado === 'APROBADO POR RPA' || detalle.estado === 'aprobado por rpa') {
                            siguiente = "ERICK ZAMURIANO CORRALES";
                        } else if (detalle.estado === 'RECHAZADO POR RPA' || detalle.estado === 'rechazado por rpa') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "SOLICITUD RECHAZADA; SE REVISARA EL PROCESO";
                        } else if (detalle.estado === 'PROVEEDOR ASIGNADO' || detalle.estado === 'proveedor asignado') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                        } else if (detalle.estado === 'VISTO BUENO RPA' || detalle.estado === 'visto bueno rpa') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "ERNESTO SEJAS";
                        } else if (detalle.estado === 'VISTO BUENO G.A.' || detalle.estado === 'visto bueno G.A.') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                        } else if (detalle.estado === 'SIN VISTO BUENO G.A.' || detalle.estado === 'sin visto bueno G.A.' || detalle.estado === 'sin visto bueno RPA' || detalle.estado === 'sin visto bueno RPA') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "SOLICITUD RECHAZADA; SE REVISARA EL PROCESO";
                        } else if (detalle.estado === 'MEMORANDUN CREADO' || detalle.estado === 'memorandun creado') {
                            // siguiente = "ROBERTO CARLOS AGUILAR RODRIGUEZ";
                            siguiente = "PROCESO DE LA SOLICITUD TERMINADO";
                        }
                        const rowClass = (detalle.retraso == "si") ? 'retraso' : '';
                        tabla2 += `<tr align='center' class='${rowClass}'>
                                <td>${decodeURIComponent(contador)}</td>
                                <td>${decodeURIComponent(detalle.tipo_solicitud)}</td>
                                <td>${decodeURIComponent(detalle.fecha)}</td>
                                <td>${decodeURIComponent(detalle.pruebas_diff)}</td>
                                <td>${decodeURIComponent(detalle.responsable)}</td>
                                <td>${decodeURIComponent(detalle.estado)}</td>
                                <td>${decodeURIComponent(siguiente)}</td>`;
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
        // $(document).ready(function() {
        $('a.derivar_modal').click(function(e) {
            e.preventDefault();
            dir = $(this).attr("href");
            console.log(dir);
            $('#mostrar_modal').load(dir);
        });
        // });
    })
</script>

<style>
    .retraso {
        background-color: red;
        color: white;
    }
</style>