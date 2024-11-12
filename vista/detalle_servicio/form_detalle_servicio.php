<?php



$id_solicitud_servicio = $_GET[id_solicitud_servicio];

// almacenar el id de la solicitud en los detalles de la solicitud

// $registros_m =  $bd->Consulta("select * from servicio");
$registros_s = $bd->Consulta("select * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio");
$registros_solicitud = $bd->Consulta("select * from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio");
$registro_sol = $bd->getFila($registros_solicitud);
// $partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
 $sum_total = $bd->Consulta("SELECT SUM(precio_total) as total FROM detalle_servicio WHERE id_solicitud_servicio = $id_solicitud_servicio");
 $s_total = $bd->getFila($sum_total);

?>

<style>
    .d-none {
        display: none;
    }
</style>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    Detalle Solicitud Servicio Formulario CM - 02
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <h4>Objetivo: <strong><?php echo utf8_encode($registro_sol[objetivo_contratacion]);?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($registro_sol[justificativo]);?></strong></h4>
        <h4>Fecha de solicitud: <strong><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo utf8_encode($registro_sol[nombre_solicitante]); ?></strong></h4>

        <form name="frm_detalle_servicio" id="frm_detalle_servicio" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">
            <input type="hidden" id="id_solicitud_servicio" name="$id_solicitud_servicio" value="<?php echo $id_solicitud_servicio; ?>">
            <input type="hidden" name="total_usado" id="total_usado" value="<?php echo $s_total[total] ;?>">
            <div class="form-group">
                <label for="descripcion_servicio" class="col-sm-2 control-label">Descripcion del Servicio</label>
                <div class="col-sm-4">
                    <textarea name="descripcion_servicio" id="descripcion_servicio" rows="4" class="form-control required text uppercase" placeholder="Escribir descripcion del servicio..."></textarea>
                </div>
                <label for="unidad_medida" class="col-sm-1 control-label">Unidad</label>
                <div class="col-sm-4">
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" title="Introducir unidad de medida" value="SERVICIO" />
                </div>
            </div>
            <div class="form-group">
                <label for="cantidad_solicitada" class="col-sm-2 control-label">Cantidad Solicitada</label>
                <div class="col-sm-4">
                    <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control decimal" placeholder="Cantidad a solicitar" min="1" />
                </div>
                <label for="precio_unitario" class="col-sm-1 control-label">Precio Unitario</label>
                <div class="col-sm-4">
                    <input type="text" name="precio_unitario" id="precio_unitario" class="form-control decimales" title="Introducir precio unitario" placeholder="Introducir precio..." />
                </div>

            </div>
            <!-- <div class="form-group">
                <label for="id_partida" class="col-sm-2 control-label">Partida</label>
                <div class="col-sm-9">
                    <select name="id_partida" id="id_partida" class="form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
                        // while ($partida = $bd->getFila($partidas)) {
                        //     echo utf8_encode("<option value='$partida[id_partida]'>$partida[codigo_partida] - $partida[nombre_partida]</option>");
                        // }
                        ?>

                    </select>
                </div>
            </div> -->
            <div class="form-group">
                <label for="precio_total" class="col-sm-2 control-label">Precio Total</label>
                <div class="col-sm-9">
                    <input type="number" min="0" max="10000" name="precio_total" id="precio_total" class="form-control decimales" readonly />
                </div>
            </div>
            <button type="button" class="btn btn-green btn-icon pull-right" style="margin-right:80px;" id="agregar">
                Agregar <i class="entypo-plus"></i>
            </button>
        </form>
    </div>
    <h3>Detalle de servicios</h3>
    <div id="detalle_servicioes" class="col-sm-12 table-responsive">
        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 5%;">Nro</th>
                    <th style="width: 25%;">Descripci&oacute;n</th>
                    <th style="width: 15%;">Unidad de medida</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 15%;">Precio Unitario</th>
                    <th style="width: 15%;">Precio Total</th>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbl_body">
                <!-- realizar una consulta de acuerdo a la solicitud si tiene servicioes $solicitud->servicioes->count() e imprimir aqui -->
                <?php
                while ($registro_s = $bd->getFila($registros_s)) {
                    $n++;
                    echo "<tr>"; ?>
                    <td style="text-align: center;"> <?php echo $n; ?></td>
                    <td style="text-align: center;"> <?php echo utf8_encode($registro_s[descripcion]); ?></td>
                    <td style="text-align: center;"> <?php echo utf8_encode($registro_s[unidad_medida]); ?></td>
                    <td style="text-align: center;"> <?php echo $registro_s[cantidad_solicitada]; ?></td>
                    <td style="text-align: center;"> <?php echo number_format($registro_s[precio_unitario], 2, ',', '.'); ?> Bs.</td>
                    <td style="text-align: center;"> <?php echo number_format($registro_s[precio_total], 2, ',', '.'); ?> Bs.</td>
                    <td style="text-align: center;">
                        <a href='?mod=detalle_servicio&pag=editar_detalle_servicio&id=<?php echo $registro_s[id_detalle_servicio]; ?>' class='btn btn-info btn-icon btn-xs' style='float: right;'>Editar <i class='entypo-pencil'></i></a><br>

                        <a href='control/detalle_servicio/eliminar_detalle_servicio.php?id_detalle_servicio=<?php echo $registro_s[id_detalle_servicio]; ?>' class='eliminar_lista btn btn-red btn-icon btn-xs' style='float: right;'>Quitar <i class='entypo-cancel'></i></a> <br>

                        <a href='?mod=especificacion_servicio&pag=index&id=<?php echo $registro_s[id_detalle_servicio]; ?>' class='btn btn-info btn-icon btn-xs' style='float: right;'>Especificar&nbsp;<i class='entypo-plus'></i></a>
                    </td>
                <?php echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    const input = document.getElementById('precio_unitario');
    const cantidad = document.getElementById('cantidad_solicitada');
    cantidad.addEventListener('blur', function() {
        const valor = this.value.trim(); // eliminamos los espacios en blanco al inicio y al final
        if (isNaN(valor)) {
            alert('Debe ingresar un número válido.');
            this.value = ''; // borra el valor introducido
        }
    })

    input.addEventListener('input', function() {
        const valor = this.value.trim(); // eliminamos los espacios en blanco al inicio y al final
        if (isNaN(valor)) {
            alert('Debe ingresar un número válido.');
            this.value = ''; // borra el valor introducido
        } else {
            let cantidad = parseFloat(document.getElementById('cantidad_solicitada').value);
            let precio = parseFloat(this.value);
            console.log(cantidad + '+' + precio);
            let total = Math.round((cantidad * precio) * 100) / 100;
            console.log(total);
            document.getElementById('precio_total').value = total;
        }

    });


    document.getElementById("agregar").addEventListener("click", function() {
        agregar_detalles();
        // alert("Agregar_detalles");
    });

    function agregar_detalles() {
        var id_solicitud_servicio = document.getElementById("id_solicitud_servicio").value;
        var descripcion_servicio = document.getElementById("descripcion_servicio").value !== '' ? document.getElementById("descripcion_servicio").value.toUpperCase() : '';
        var unidad_medida = document.getElementById("unidad_medida").value !== '' ? document.getElementById("unidad_medida").value.toUpperCase() : '';
        var precio_unitario = document.getElementById("precio_unitario").value !== '' ? document.getElementById("precio_unitario").value : 0;
        var cantidad_solicitada = parseFloat(document.getElementById("cantidad_solicitada").value);
        // var id_partida = document.getElementById("id_partida").value;
        var precio_total = parseFloat(document.getElementById("precio_total").value);
        var total_usado = parseFloat(document.getElementById("total_usado").value);

        var data = [{
                name: "id_solicitud_servicio",
                value: id_solicitud_servicio
            },
            {
                name: "descripcion_servicio",
                value: descripcion_servicio
            },
            {
                name: "unidad_medida",
                value: unidad_medida
            },
            {
                name: "precio_unitario",
                value: precio_unitario
            },
            {
                name: "cantidad_solicitada",
                value: cantidad_solicitada
            },
            // {
            //     name: "id_partida",
            //     value: id_partida
            // },
            {
                name: "precio_total",
                value: precio_total
            },
            {
                name: "total_usado",
                value: total_usado
            },
        ];

        console.table(data);

        if (cantidad_solicitada === '') {
            jAlert("Defina la Cantidad Deseada.", "Mensaje");
            document.getElementById("cantidad_solicitada").focus();
            return;
        }
        // if (id_partida === '') {
        //     jAlert("Seleccione una partida.", "Mensaje");
        //     document.getElementById("id_partida").focus();
        //     return;
        // }

        var url = "control/detalle_servicio/insertar_detalle_servicio.php";
        var data = new URLSearchParams();
        data.append('id_solicitud_servicio', id_solicitud_servicio);
        // data.append('id_partida', id_partida);
        data.append('descripcion_servicio', descripcion_servicio);
        data.append('unidad_medida', unidad_medida);
        data.append('cantidad_solicitada', cantidad_solicitada);
        data.append('precio_unitario', precio_unitario);
        data.append('precio_total', precio_total);
        data.append('total_usado', total_usado);
        fetch(url, {
                method: 'POST',
                body: data
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
    }

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

        // function agregar() {
        //     var id_solicitud_servicio     = $("#id_solicitud_servicio").val();
        //     var descripcion_servicio      = $("#descripcion_servicio").val() != '' ? $("#descripcion_servicio").val() : '';
        //     var unidad_medida             = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
        //     var cantidad_solicitada       = parseFloat($("#cantidad_solicitada").val());
        //     var precio_unitario           = $("#precio_unitario").val() != '' ? parseFloat($("#precio_unitario").val()) : 0;
        //     var precio_total              = $("#precio_total").val() != '' ? parseFloat($("#precio_total").val()) : 0;
        //     var id_partida                = parseFloat($("#id_partida").val());
        //     if (cantidad_solicitada == '') {
        //         jAlert("Seleccione o introduzca servicio.", "Mensaje");
        //     } else {
        //         if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {
        //             jAlert("Introduzca una cantidad v&aacute;lida.", "Mensaje", function(reso) {
        //                 $("#cantidad_solicitada").focus();
        //             });
        //         } else {
        //             $.ajax({
        //                 type: "POST",
        //                 url: "control/detalle_servicio/insertar_detalle_servicio.php",
        //                 data: {
        //                     'id_solicitud_servicio': id_solicitud_servicio,
        //                     'descripcion_servicio': descripcion_servicio,
        //                     'unidad_medida': unidad_medida,
        //                     'cantidad_solicitada': cantidad_solicitada,
        //                     'precio_unitario': precio_unitario,
        //                     'id_partida': id_partida,
        //                     'precio_total': precio_total
        //                 }
        //             }).done(function(response) {
        //                 var data = JSON.parse(response);
        //                 console.log(response)
        //                 if (data.success === true) {
        //                     window.location.reload();
        //                 } else {
        //                     jAlert(data.message, "Mensaje")
        //                 }
        //             }).fail(function(response) {
        //                 console.log(response)
        //             })

        //         }
        //     }
        // }

        // $("#agregar").click(function() {
        //     agregar();
        // });

    });
</script>