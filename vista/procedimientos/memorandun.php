<?php
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$id_derivacion = $_GET[id_derivacion];
$id_detalle    = $_GET[id_detalle];
$tipo          = $_GET[tipo];
// echo $id_derivacion."-".$id_detalle;
$datos = $bd->Consulta("SELECT r.id_solicitud, r.id_proveedor 
    FROM requisitos as r 
    INNER JOIN derivaciones as d ON d.id_derivacion = r.id_derivaciones 
    WHERE d.id_derivacion=$id_derivacion 
    AND r.id_detalle=$id_detalle");
$dato = $bd->getFila($datos);
// var_dump($dato);
// echo $dato[id_solicitud]." - ".$dato[id_proveedor];
if ($tipo == "material") {
    $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material as id_detalle
            FROM solicitud_material as s 
            INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
            INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
            WHERE s.id_solicitud_material=$dato[id_solicitud]
            AND r.id_proveedor=$dato[id_proveedor] GROUP BY r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material");
    // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
} elseif ($tipo == 'activo') {
    $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo as id_detalle
            FROM solicitud_activo as s 
            INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo
            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
            INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
            where s.id_solicitud_activo= $dato[id_solicitud]
            AND r.id_proveedor=$dato[id_proveedor] GROUP BY r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo");
    // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
} else {
    $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio as id_detalle
        FROM solicitud_servicio as s 
        INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio
        INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
        INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
        where s.id_solicitud_servicio = $dato[id_solicitud]
        AND r.id_proveedor=$dato[id_proveedor] GROUP BY r.id_requisitos, p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio");
    // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
}
$trabajadores = $bd->Consulta("SELECT * FROM trabajador");
$trabajadores2 = $bd->Consulta("SELECT * FROM trabajador");
$array = array();
$ids = array();
$uno = "block";
$dos = "none";
?>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    PROCEDIMIENTOS RPA
</h2>
<br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>No</th>
                <th>Proveedor</th>
                <th>Fecha de Elaboracion</th>
                <th>Detalles de <br>la Solicitud</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody id="tbodyactas">
            <?php
            $n = 0;
            while ($registro_requisitos = $bd->getFila($detalles_de_solicitud_por_requisito)) {
                $n++;
                if ($tipo == "material") {
                    $requisitos_detallados = $bd->Consulta("SELECT *, d.id_detalle_material as id_detalle
                            FROM detalle_material as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                            WHERE id_solicitud_material=$dato[id_solicitud]
                            AND  r.id_proveedor=$dato[id_proveedor]");
                } elseif ($tipo == 'activo') {
                    $requisitos_detallados = $bd->Consulta("SELECT *, d.id_detalle_activo as id_detalle
                            FROM detalle_activo as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo 
                            where id_solicitud_activo= $dato[id_solicitud]
                            AND  r.id_proveedor=$dato[id_proveedor]");
                } else {
                    $requisitos_detallados = $bd->Consulta("SELECT *, d.id_detalle_servicio as id_detalle
                        FROM detalle_servicio as d
                        INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
                        where id_solicitud_servicio = $dato[id_solicitud]
                        AND  r.id_proveedor=$dato[id_proveedor]");
                }
            ?>
                <tr>
                    <td><?php echo $n; ?></td>
                    <td><?php echo utf8_encode("$registro_requisitos[nombre] - $registro_requisitos[nit]"); ?></td>
                    <td><?php echo utf8_encode("$registro_requisitos[fecha_elaboracion]"); ?></td>
                    <td>
                        <?php

                        while ($detalles = $bd->getFila($requisitos_detallados)) {
                            $array = array(
                                "id_detalle" => $detalles[id_detalle]
                            );
                            array_push($ids, $array);
                            echo utf8_encode("<ul>
                                    <li>
                                        $detalles[descripcion] - $detalles[unidad_medida] - $detalles[cantidad_solicitada]
                                    </li>
                                </ul>");
                        } ?>
                    </td>
                    <td>
                        <?php
                        // print_r($ids);
                        foreach ($ids as $key) {
                            $verificar_procedimientos = $bd->Consulta("SELECT * FROM procedimientos WHERE id_detalles=$key[id_detalle]");
                            $verificar_proc = $bd->getFila($verificar_procedimientos);
                        }
                        if ($verificar_proc) {
                            $uno = "none";
                            $dos = "block";
                        } else {
                            $uno = "block";
                            $dos = "none";
                        }
                        // echo "ID_REQUISITOS: ".$registro_requisitos[id_requisitos];
                        ?>
                        <div style="display: <?php echo $uno; ?>;">
                            <button data_id="<?php echo $dato[id_proveedor] . "-" . $dato[id_solicitud] . "-" . $id_derivacion . "-" . $tipo ?>" data-toggle="modal" data-target="#existencia_solicitud" class="btn btn-success btn-icon btn-xs" onclick="memorandun()">Asignar<i class="entypo-plus"></i></button><br>
                        </div>
                        <div style="display: <?php echo $dos; ?>;">
                            <a target='_blank' href="vista/procedimientos/memorandun_pdf.php?id_solicitud=<?php echo $dato[id_solicitud]; ?>&id_detalle=<?php echo $ids; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">Imprimir Memorandun<i class="entypo-print"></i></a><br>





                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<!-- existencia de la Solicitud -->
<div class="modal fade" id="existencia_solicitud" role="dialog">
    <div class="modal-dialog">
        <!-- existencia de la Solicitud content-->
        <!-- href="control/derivaciones/verificar.php?id=<?php // echo $registro[id_derivacion] 
                                                            ?>" -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Designacion</h4>
            </div>
            <div class="modal-body">
                <!-- action="control/procedimientos/insertar_procedimientos.php" -->
                <form name="frm_derivaciones" id="frm_derivaciones" action="control/procedimientos/insertar_procedimientos.php" method="post" role="form" class="form-horizontal form-groups-bordered" enctype="multipart/form-data">
                    <input type="hidden" name="val_id_proveedor" id="val_id_proveedor">
                    <input type="hidden" name="val_id_solicitud" id="val_id_solicitud">
                    <input type="hidden" name="val_id_derivacion" id="val_id_derivacion">
                    <input type="hidden" name="val_tipo" id="val_tipo">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
                    <!-- Fecha de verificacion -->
                    <div class="form-group">
                        <label for="fecha_respuesta" class="col-sm-2 control-label">Fecha respuesta</label>
                        <div class="col-sm-8">
                            <input type="text" name="fecha_respuesta" id="fecha_respuesta" class="form-control required datepicker" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cuce" class="col-sm-2 control-label">CUCE si corresponde</label>
                        <div class="col-sm-8">
                            <input type="text" name="cuce" id="cuce" class="form-control required" placeholder="Una ves registrado el CUCE no se podra cambiar!." />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rpa" class="col-sm-2 control-label">Personal Responsable RPA</label>
                        <div class="col-sm-8">
                            <select id="rpa" name="rpa" class="form-control required select2">
                                <option value="" selected>--SELECCIONE--</option>
                                <?php
                                while ($trabajador = $bd->getFila($trabajadores)) {
                                    echo utf8_encode("<option value='$trabajador[id_trabajador]'>$trabajador[nombres] - $trabajador[apellido_paterno] - $trabajador[apellido_materno]</option>");
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsables" class="col-sm-2 control-label">Designar Responsable A:</label>
                        <div class="col-sm-8">
                            <select name="responsables[]" id="responsables" multiple="multtiple" class="form-control required select2 multiple">
                                <!-- <option value="" selected>--SELECCIONE--</option> -->
                                <?php
                                while ($trabajador_res = $bd->getFila($trabajadores2)) {
                                    echo utf8_encode("<option value='$trabajador_res[id_trabajador]'>$trabajador_res[nombres]  $trabajador_res[apellido_paterno]  $trabajador_res[apellido_materno]</option>");
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="button" id="agregar" class="btn btn-info">Registrar</button>
                            <!-- <button type="button" id="agregar" class="btn btn-info">Registrar</button> -->
                            <!-- <button type="button" class="btn cancelar">Cancelar</button> -->
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>

    </div>
</div>
<div id="modalAclaraciones" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Acta recepción</h3>
                <button class="close" id="btnCerrarModal" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formAclaraciones" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aclaraciones">Condiciones Adicionales y/o Aclaraciones</label>
                            <textarea class="form-control" name="textAclaraciones" id="textAclaraciones" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalObservacionesForm10" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Ingreso y Egreso</h3>
                <button type="button" class="close" id="btnCerrarModalform10" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formObservacionesForm10" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObservacionesForm10" id="textObservacionesForm10" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalObservacionesForm11" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Recepción y Conformidad</h3>
                <button type="button" class="close" id="btnCerrarModalform11" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formObservacionesForm11" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObservacionesForm11" id="textObservacionesForm11" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalAsignacionBienes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Asignacion de Bienes</h3>
                <button type="button" class="close" id="btnCerrarAsignacionBienes" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formAsignacionesBienes" class="form" autocomplete="off">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numFactura">Nro Factura (*)</label>
                            <input type="text" class="form-control" name="numFactura" id="numFacturaAsignaccionBienes" required>
                            <label for="fechaFactura">Fecha Factura(*)</label>
                            <input type="date" class="form-control datepicker" name="fechaFactura" id="fechaFacturaAsignaccionBienes" required>
                        </div>
                        <div class="form-group">
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObsAsignaccionBienes" id="textObsAsignaccionBienes" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $("#tbodyactas").click(function(e) {

            let nombre = e.target.getAttribute('name');
            if (nombre != null && nombre == 'acta-recepcion') {
                document.getElementById('formAclaraciones').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalAclaraciones').modal('show');
            } else if (nombre != null && nombre == 'observaciones-form10') {
                document.getElementById('formObservacionesForm10').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalObservacionesForm10').modal('show');
            } else if (nombre != null && nombre == 'observaciones-form11') {
                document.getElementById('formObservacionesForm11').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalObservacionesForm11').modal('show');
            } else if (nombre != null && nombre == 'asignacion-bienes') {
                document.getElementById('formAsignacionesBienes').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalAsignacionBienes').modal('show');
            }

        });
        // $("#agregar").click(function() {
        //     let rpa         = $("#rpa").val();
        //     let responsable = $("#responsable").val();
        //     let cuce        = $("#cuce").val();
        //     console.log(rpa);
        // });
    })

    // Obtener el botón por su ID
    const agregarBtn = document.getElementById("agregar");

    // Agregar un evento de clic al botón
    agregarBtn.addEventListener("click", function() {
        // Obtener los valores de los campos
        const val_id_proveedor = document.getElementById("val_id_proveedor").value;
        const val_id_solicitud = document.getElementById("val_id_solicitud").value;
        const val_id_derivacion = document.getElementById("val_id_derivacion").value;
        const val_tipo = document.getElementById("val_tipo").value;
        const fechaRespuesta = document.getElementById('fecha_respuesta').value;
        const cuce = document.getElementById('cuce').value;
        const rpa = document.getElementById('rpa').value;
        const responsables = Array.from(document.querySelectorAll('#responsables option:checked')).map(option => option.value);
        const idUsuario = document.getElementById('id_usuario').value;

        // Crear un objeto con los datos
        const show_data = {
            'val_id_proveedor': val_id_proveedor,
            'val_id_solicitud': val_id_solicitud,
            'val_id_derivacion': val_id_derivacion,
            'val_tipo': val_tipo,
            "Fecha de Respuesta": fechaRespuesta,
            "CUCE": cuce,
            "RPA": rpa,
            "Responsables": responsables,
            "ID Usuario": idUsuario
        };

        // Mostrar la tabla en la consola
        console.table(show_data);

        var datos = new FormData();
        datos.append('val_id_proveedor', val_id_proveedor);
        datos.append('val_id_solicitud', val_id_solicitud);
        datos.append('val_id_derivacion', val_id_derivacion);
        datos.append('val_tipo', val_tipo);
        datos.append('fecha_respuesta', fechaRespuesta);
        datos.append('cuce', cuce);
        datos.append('rpa', rpa);
        responsables.forEach(responsable => {
            datos.append('responsables[]', responsable);
        });
        datos.append('id_usuario', idUsuario);
        // Ruta de la dirección
        const ruta = "control/procedimientos/insertar_procedimientos.php";

        // Enviar los datos al controlador utilizando fetch con el método POST
        fetch(ruta, {
                method: 'POST',
                body: datos
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success === true) {
                    window.location.reload();
                } else {
                    // alert(data.message);
                    jAlert(data.message, "Mensaje")
                }
            })
            .catch(error => {
                console.log(error);
            });
    });

    function memorandun() {
        var boton = event.target;
        var dataId = boton.getAttribute("data_id");
        var partes = dataId.split("-");
        var id_proveedor = partes[0];
        var id_solicitud = partes[1];
        var id_derivacion = partes[2];
        var tipo = partes[3];
        console.log('ID Prov: ' + id_proveedor + " Sol: " + id_solicitud + " DERIVACION: " + id_derivacion + " Tipo " + tipo);
        document.getElementById('val_id_proveedor').innerHTML = id_proveedor;
        document.getElementById('val_id_proveedor').value = id_proveedor;
        document.getElementById('val_id_solicitud').innerHTML = id_solicitud;
        document.getElementById('val_id_solicitud').value = id_solicitud;
        document.getElementById('val_id_derivacion').innerHTML = id_derivacion;
        document.getElementById('val_id_derivacion').value = id_derivacion;
        document.getElementById('val_tipo').innerHTML = tipo;
        document.getElementById('val_tipo').value = tipo;
    }
    document.getElementById("formAclaraciones").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formAclaraciones');
        let enlace = formulario.getAttribute('enlace');
        let aclaracion = document.getElementById('textAclaraciones').value;
        let enlace_pdf = enlace + '&aclaracion=' + aclaracion;
        let btnCerrarModal = document.getElementById('btnCerrarModal');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalObservacionesForm10").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formObservacionesForm10');
        let enlace = formulario.getAttribute('enlace');
        let observaciones = document.getElementById('textObservacionesForm10').value;
        let enlace_pdf = enlace + '&observaciones=' + observaciones;
        let btnCerrarModal = document.getElementById('btnCerrarModalform10');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalObservacionesForm11").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formObservacionesForm11');
        let enlace = formulario.getAttribute('enlace');
        let observaciones = document.getElementById('textObservacionesForm11').value;
        let enlace_pdf = enlace + '&observaciones=' + observaciones;
        let btnCerrarModal = document.getElementById('btnCerrarModalform11');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalAsignacionBienes").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formAsignacionesBienes');
        let enlace = formulario.getAttribute('enlace');
        let observaciones = document.getElementById('textObsAsignaccionBienes').value;
        let nro_factura = document.getElementById('numFacturaAsignaccionBienes').value;
        let fecha_factura = document.getElementById('fechaFacturaAsignaccionBienes').value;
        let enlace_pdf = enlace + '&nro_factura=' + nro_factura + '&fecha_factura=' + fecha_factura + '&observaciones=' + observaciones;
        let btnCerrarModal = document.getElementById('btnCerrarAsignacionBienes');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
</script>