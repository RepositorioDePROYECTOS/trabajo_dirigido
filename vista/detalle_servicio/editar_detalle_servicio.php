<?php
$id = $_GET[id];
// echo $id;
$partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
$registros_solicitud = $bd->Consulta("SELECT s.fecha_solicitud, s.nombre_solicitante
FROM solicitud_servicio as s 
INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
WHERE d.id_detalle_servicio=$id GROUP BY d.id_detalle_servicio");
$solicituds = $bd->Consulta("SELECT * FROM detalle_servicio WHERE id_detalle_servicio=$id");
$solicitud = $bd->getFila($solicituds);
$registro_sol = $bd->getFila($registros_solicitud);

$registros_s = $bd->Consulta("SELECT * from detalle_servicio where id_detalle_servicio=$id");
$servicio = $bd->getFila($registros_s);
// var_dump($servicio);

?>

<style>
    .d-none {
        display: none;
    }
</style>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    Detalle de la solicitud Formulario CM - 02
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <h4>Objetivo: <strong><?php echo utf8_encode($registro_sol[objetivo_contratacion]);?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($registro_sol[justificativo]);?></strong></h4>
        <h4>Fecha de solicitud: <strong><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo utf8_encode($registro_sol[nombre_solicitante]); ?></strong></h4>

        <form name="frm_detalle_servicio" id="frm_detalle_servicio" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">
            <input type="hidden" id="id_detalle_servicio" name="id_detalle_servicio" value="<?php echo $id; ?>">
            <input type="hidden" id="id_solicitud_servicio" name="id_solicitud_servicio" value="<?php echo $servicio[id_solicitud_servicio]; ?>">
            <div class="form-group">
                <label for="descripcion_servicio" class="col-sm-2 control-label">Descripcion del Servicio</label>
                <div class="col-sm-4">
                    <textarea name="descripcion_servicio" id="descripcion_servicio" rows="4" class="form-control required text uppercase" placeholder="Escribir descripcion del servicio..."><?php echo utf8_encode($servicio[descripcion]); ?></textarea>
                </div>
                <label for="unidad_medida" class="col-sm-1 control-label">Unidad</label>
                <div class="col-sm-4">
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" title="Introducir unidad de medida" value="<?php echo utf8_encode($servicio[unidad_medida]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="cantidad_solicitada" class="col-sm-2 control-label">Cantidad Solicitada</label>
                <div class="col-sm-4">
                    <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control decimal" value="<?php echo $servicio[cantidad_solicitada]; ?>" min="1" />
                </div>
                <label for="precio_unitario" class="col-sm-1 control-label">Precio Unitario</label>
                <div class="col-sm-4">
                    <input type="text" name="precio_unitario" id="precio_unitario" class="form-control decimales" title="Introducir precio unitario" value="<?php echo $servicio[precio_unitario]; ?>" />
                </div>

            </div>
            <!-- <div class="form-group">
                    <label for="id_partida" class="col-sm-2 control-label">Partida</label>
                    <div class="col-sm-9">
                        <select name="id_partida" id="id_partida" class="form-control required select2">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php
                            while ($partida = $bd->getFila($partidas)) {
                                $selected_autorizado = $solicitud[id_partida] == $partida[id_partida] ? 'selected' : '';
                                echo utf8_encode("<option value='$partida[id_partida]' $selected_autorizado>$partida[codigo_partida] - $partida[nombre_partida]</option>");
                            }
                            ?>

                        </select>
                    </div>
                </div> -->
            <div class="form-group">
                <label for="precio_total" class="col-sm-2 control-label">Precio Total</label>
                <div class="col-sm-9">
                    <input type="number" min="0" max="10000" name="precio_total" id="precio_total" class="form-control decimales" value="<?php echo $servicio[precio_total]; ?>" readonly />
                </div>
            </div>
            <button type="button" class="btn btn-green btn-icon pull-right" style="margin-right:80px;" id="agregar">
                Actualizar <i class="entypo-plus"></i>
            </button>
        </form>
    </div>
</div>
<script type="text/javascript">
    function borrarInput() {
        var input = event.target;
        var precio_input = document.getElementById('precio_unitario');
        var precio_t_input = document.getElementById('precio_total');
        input.value = '';
        precio_input.value = '';
        precio_t_input.value = '';
    }
    var miInput = document.getElementById("cantidad_solicitada");
    miInput.addEventListener("click", borrarInput);
    
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
            var id_detalle_servicio       = $('#id_detalle_servicio').val();
            var id_solicitud_servicio     = $("#id_solicitud_servicio").val();
            var descripcion_servicio      = $("#descripcion_servicio").val() != '' ? $("#descripcion_servicio").val() : '';
            var unidad_medida             = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
            var cantidad_solicitada       = parseFloat($("#cantidad_solicitada").val());
            var precio_unitario           = $("#precio_unitario").val() != '' ? parseFloat($("#precio_unitario").val()) : 0;
            var precio_total              = $("#precio_total").val() != '' ? parseFloat($("#precio_total").val()) : 0;
            // var id_partida                = parseFloat($("#id_partida").val());
            if (cantidad_solicitada == '') {
                jAlert("Seleccione o introduzca servicio.", "Mensaje");
            } else {
                if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {
                    jAlert("Introduzca una cantidad v&aacute;lida.", "Mensaje", function(reso) {
                        $("#cantidad_solicitada").focus();
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "control/detalle_servicio/editar_detalle_servicio.php",
                        data: {
                            'id_detalle_servicio': id_detalle_servicio,
                            'id_solicitud_servicio': id_solicitud_servicio,
                            'descripcion_servicio': descripcion_servicio,
                            'unidad_medida': unidad_medida,
                            'cantidad_solicitada': cantidad_solicitada,
                            'precio_unitario': precio_unitario,
                            // 'id_partida': id_partida,
                            'precio_total': precio_total
                        }
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        console.log(response)
                        if (data.success === true) {
                            window.location.reload();
                            jAlert(data.message, "Mensaje")
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

    });
</script>