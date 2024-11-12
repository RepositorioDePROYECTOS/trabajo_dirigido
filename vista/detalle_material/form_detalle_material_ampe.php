<?php

include("modelo/material.php");
include("modelo/detalle_material.php");

$id_solicitud_material = $_GET[id_solicitud_material];

// almacenar el id de la solicitud en los detalles de la solicitud

$detalle_material = new detalle_material();
$registros_m =  $bd->Consulta("select * from material");
$registros_s = $bd->Consulta("select * from detalle_material where id_solicitud_material=$id_solicitud_material");
$registros_solicitud = $bd->Consulta("select * from solicitud_material where id_solicitud_material=$id_solicitud_material");
$registro_sol = $bd->getFila($registros_solicitud);

?>

<style>
    .d-none {
        display: none;
    }
</style>
<h2>Detalle de la solicitud</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <form name="frm_detalle_material" id="frm_detalle_material" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">
            <div class="form-group">

                <label for="fecha_registro" class="col-sm-2 control-label">Fecha de solicitud</label>
                <div class="col-sm-2">
                    <input type="text" name="fecha_registro" id="fecha_registro" class="form-control required datepicker" placeholder='' value='<?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?>' readonly />
                </div>
                <label for="trabajador" class="col-sm-3 control-label">Nombre Solicitante</label>
                <div class="col-sm-3">
                    <input type="text" name="trabajador" id="trabajador" class="form-control required text" placeholder='' value='<?php echo utf8_encode($registro_sol[nombre_solicitante]); ?>' readonly />
                </div>
            </div>

            <div class="form-group bg-oferta">
                <div class="col-sm-10"><strong>AGREGAR MATERIALES A SOLICITAR <?= ($registro_sol[existencia_material] == 'NO') ? '<span class="text-danger">(NOTA * Registrar solo material no existente en almacén)</span>' : '' ?></strong> </div>
            </div>
            <input type="hidden" id="id_solicitud_material" name="$id_solicitud_material" value="<?php echo $id_solicitud_material; ?>">
            <div class="form-group bg-oferta">
                <label for="material" class="col-sm-1 control-label">Material</label>
                <div class="col-sm-12">
                    <div class="row">
                        <?php if ($registro_sol[existencia_material] != 'NO') { ?>
                            <div class="col-md-3">
                                <select name="id_material" id="id_material" class=" id_material form-control required select2">
                                    <option value="" selected>--SELECCIONE--</option>
                                    <?php
                                    while ($registro_m = $bd->getFila($registros_m)) {
                                        echo utf8_encode("<option value='$registro_m[id_material]'>$registro_m[codigo]-$registro_m[descripcion] ($registro_m[unidad_medida])</option>");
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3" id="key_cantidad">
                                <input type="text" name="cantidad_material" id="cantidad_material" class="form-control" placeholder="Cantidad de material existente" readonly />
                                <input type="hidden" name="unidad_medida" id="unidad_medida">
                                <input type="hidden" name="precio_unitario" id="precio_unitario">
                            </div>
                            <input type="hidden" name="cant_mat" id="cant_mat">
                        <?php } else { ?>
                            <div class="col-md-3 " id="key_descripcion">
                                <input type="hidden" name="id_material" id="id_material" value="0">
                                <textarea name="descripcion_material" id="descripcion_material" class="form-control required text uppercase" placeholder="Escribir descripcion del material..."></textarea>
                            </div>
                            <div class="col-md-2 ">
                                <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" title="Introducir unidad de medida" placeholder="Introducir Unidad medida..." />
                            </div>
                            <div class="col-md-2 " id="key_precio">
                                <input type="text" name="precio_unitario" id="precio_unitario" class="form-control decimales" title="Introducir precio unitario" placeholder="Introducir precio..." step="any" />
                            </div>
                        <?php } ?>
                        <div class="col-md-2">
                            <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control decimales" placeholder="Cantidad a solicitar" min="1" step="any" />
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-green btn-icon pull-right" style="margin-top:5px;" id="agregar">
                                Agregar <i class="entypo-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="detalle_materiales" class="col-sm-2 control-label">Detalle de materiales</label>
                <div id="detalle_materiales" class="col-sm-10 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Descripci&oacute;n</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                            <!-- realizar una consulta de acuerdo a la solicitud si tiene materiales $solicitud->materiales->count() e imprimir aqui -->
                            <?php
                            while ($registro_s = $bd->getFila($registros_s)) {
                                $n++;
                                echo "<tr>";
                                echo utf8_encode(
                                    "
                                    <td>$n</td>
                                    <td>$registro_s[descripcion]</td>
                                    <td>$registro_s[unidad_medida]</td>
                                    <td>$registro_s[cantidad_solicitada]</td>
                                    <td>$registro_s[precio_unitario]</td>
                                    <td><a href='vista/detalle_material/eliminar_detalle_material_ampe.php?id_detalle_material=$registro_s[id_detalle_material]' class='eliminar_lista btn btn-red btn-icon'>Quitar <i class='entypo-cancel'></i></a></td>"
                                );
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="reset" class="btn btn-default cancelar pull-right">Cancelar</button>
                    <button type="reset" class="btn btn-info cancelar pull-right">Aceptar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("input[type=text]").focus(function() {
            this.select();
        });

        $("a.eliminar_lista").click(function(e) {
            e.preventDefault();
            dir = $(this).attr("href");
            jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
                if (resp) {
                    $.ajax({
                        type: "GET",
                        url: dir,
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        console.log(response)
                        if (data.success === true) {
                            window.location.reload();
                        } else {
                            jAlert("Error.", "Mensaje")
                        }
                    })
                    // window.location.reload();
                    // $(location).attr('href',dir);
                }
            });

        });

        function agregar() {
            var id_solicitud_material = $("#id_solicitud_material").val();
            var id_material = $("#id_material").val();
            var descripcion_material = $("#descripcion_material").val() != '' ? $("#descripcion_material").val().toUpperCase() : '';
            var unidad_medida = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
            var precio_unitario = $("#precio_unitario").val() != '' ? $("#precio_unitario").val() : 0;
            var cantidad_solicitada = parseFloat($("#cantidad_solicitada").val());
            if (id_material == '' || cantidad_solicitada == '') {
                jAlert("Seleccione o introduzca material.", "Mensaje");
            } else {
                if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {
                    jAlert("Introduzca una cantidad v&aacute;lida.", "Mensaje", function(reso) {
                        $("#cantidad_solicitada").focus();
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "control/detalle_material_ampe/insertar_detalle_material_ampe.php",
                        data: {
                            'id_solicitud_material': id_solicitud_material,
                            'id_material': id_material,
                            'descripcion_material': descripcion_material,
                            'unidad_medida': unidad_medida,
                            'cantidad_solicitada': cantidad_solicitada,
                            'precio_unitario': precio_unitario
                        }
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        console.log(response)
                        if (data.success === true) {
                            window.location.reload();
                        } else {
                            jAlert(data.message, "Mensaje")
                        }
                    }).fail(function(response) {
                        console.log(response)
                    })

                }
            }
        }

        $("#agregar").click(function() {
            agregar();
        });

        $('.id_material').change(function() {
            var id = $(this).val();
            if (id !== '') {
                $.ajax({
                    type: "GET",
                    url: "vista/detalle_material/detalle_material.php",
                    data: {
                        'id_detalle_material': id
                    }
                }).done(function(response) {
                    var data = JSON.parse(response);

                    if (data.success === true && data.cantidad > 0) {
                        $('#cantidad_material').val(data.cantidad + ' ' + data.unidad_medida +
                            ' restantes')
                        $('#cant_mat').val(data.cantidad);
                    } else {
                        $('#cantidad_material').val('')
                        jAlert("No tiene Stock Disponible", "Mensaje")
                    }
                })
            } else {
                console.log('seleccionar')
            }

        });
        $("#cantidad_solicitada").keyup(function(e) {
            var key = parseFloat($('#cantidad_solicitada').val());
            var cantidad_material = $('#cant_mat').val() != '' ? parseFloat($('#cant_mat').val()) : 0;
            console.log(key, cantidad_material)
            if (cantidad_material > 0) {
                if (key >= cantidad_material) {
                    jAlert("No Puede superar la cantidad existente", "Mensaje")
                }
            }

        });
    });
</script>