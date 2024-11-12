<?php

include("modelo/material.php");
include("modelo/detalle_material.php");

$id_detalle_material = $_GET[id];

// almacenar el id de la solicitud en los detalles de la solicitud

$registros_m =  $bd->Consulta("select * from material");
$partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
$solicituds = $bd->Consulta("SELECT * FROM detalle_material WHERE id_detalle_material=$id_detalle_material");
$solicitud = $bd->getFila($solicituds);
// echo var_dump($solicitud);
$registros_solicitud = $bd->Consulta("SELECT s.fecha_solicitud, s.nombre_solicitante, s.existencia_material, d.unidad_medida
FROM solicitud_material as s 
INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
WHERE d.id_detalle_material=$id_detalle_material GROUP BY d.id_detalle_material");
$registro_sol = $bd->getFila($registros_solicitud);
$unidad_de_medidas = $bd->Consulta("SELECT descripcion FROM unidad_de_medida ORDER BY descripcion");
// echo var_dump($registro_sol);

?>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    Detalle de la solicitud <?php if($registro_sol[existencia_material] == 'NO'){echo "Formulario CM-02";}?>
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
    <h4>Objetivo: <strong><?php echo utf8_encode($registro_sol[objetivo_contratacion]);?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($registro_sol[justificativo]);?></strong></h4>
        <h4>Fecha de solicitud: <strong><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo utf8_encode($registro_sol[nombre_solicitante]); ?></strong></h4>
        <h4>Existencia de material: <strong><?php echo utf8_encode($registro_sol[existencia_material]) ?></strong></h4>
        <!-- action="control/detalle_material/update_detalle_material.php" -->
        <form name="frm_update_detalle_material" id="frm_update_detalle_material" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">
            <input type="hidden" name="id_detalle_material" id="id_detalle_material" value="<?php echo $id_detalle_material ?>">
            <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->
            <input type="hidden" name="existencia" id="existencia" value="<?php echo utf8_encode($registro_sol[existencia_material]) ?>">
            <input type="hidden" name="unidad_medida_old" id="unidad_medida_old" value="<?php echo utf8_encode($registro_sol[unidad_medida]) ?>">
            <input type="hidden" name="descripcion_old" id="descripcion_old" value="<?php echo utf8_encode($solicitud[descripcion]) ?>">
            <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->
            <div class="row" id="existe" style="display: none;">
                <div class="col-md-3">
                    <label for="id_material">Material</label>
                    <select name="id_material" id="id_material" class=" id_material form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
                        while ($registro_m = $bd->getFila($registros_m)) {
                            $selected_autorizado = $solicitud[descripcion] == $registro_m[descripcion] ? 'selected' : '';
                            echo utf8_encode("<option value='$registro_m[id_material]' $selected_autorizado>$registro_m[codigo]-$registro_m[descripcion] ($registro_m[unidad_medida])</option>");
                        }
                        ?>

                    </select>
                </div>
                <div class="col-md-3" id="key_cantidad">
                    <label for="cantidad_material">Cantidad Existente</label>
                    <input type="text" name="cantidad_material" id="cantidad_material" class="form-control" value="" readonly />
                </div>
                <div class="col-md-2">
                    <label for="cantidad_solicitada">Cantidad Solicitada</label>
                    <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control decimales" value="<?php echo $solicitud[cantidad_solicitada] ?>" />
                    <input type="hidden" name="cantidad_solicitada_old" id="cantidad_solicitada_old" class="form-control decimales" value="<?php echo $solicitud[cantidad_solicitada] ?>" />
                </div>
            </div>
            <div id="no_existe" style="display: none;">
                <div class="form-group">
                    <label for="cantidad_sn" class="col-sm-3 control-label">Cantidad Solicitada</label>
                    <div class="col-sm-6">
                        <input type="textS" name="cantidad_sn" id="cantidad_sn" class="form-control" value="<?php echo utf8_encode($solicitud[cantidad_solicitada]); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="unidad_medida_sn" class="col-sm-3 control-label">Unidad de Medida</label>
                    <div class="col-sm-6">
                        <select name="unidad_medida_sn" id="unidad_medida_sn" class="form-control select2" placeholder="Introducir Unidad medida.">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php while ($unidad_medida = $bd->getFila($unidad_de_medidas)) { ?>
                                <option value="<?php echo utf8_encode(strtoupper($unidad_medida[descripcion])); ?>" <?php echo utf8_encode(strtoupper($solicitud[unidad_medida])) == utf8_encode(strtoupper($unidad_medida[descripcion])) ? 'selected' : ''; ?>><?php echo utf8_encode(strtoupper($unidad_medida[descripcion])); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion_material" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-6">
                        <textarea name="descripcion_material" id="descripcion_material" rows="4" class="form-control required text uppercase"><?php echo utf8_encode($solicitud[descripcion]); ?></textarea>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="id_partida" class="col-sm-3 control-label">Partida</label>
                    <div class="col-sm-6">
                        <select name="id_partida" id="id_partida" class="form-control required select2">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php
                            // while ($partida = $bd->getFila($partidas)) {
                                // $selected_autorizado = $solicitud[id_partida] == $partida[id_partida] ? 'selected' : '';
                                // echo utf8_encode("<option value='$partida[id_partida]' $selected_autorizado>$partida[codigo_partida] - $partida[nombre_partida]</option>");
                            // }
                            ?>

                        </select>
                    </div>
                </div> -->
                <div class="form-group">
                    <label for="precio_unitario_sn" class="col-sm-3 control-label">Precio Unitario</label>
                    <div class="col-sm-6">
                        <input type="text" name="precio_unitario_sn" id="precio_unitario_sn" class="form-control decimales" value="<?php echo $solicitud[precio_unitario] ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="precio_total" class="col-sm-3 control-label">Precio Total</label>
                    <div class="col-sm-6">
                        <input type="number" min="0" max="10000" name="precio_total" id="precio_total" class="form-control decimales" value="<?php echo $solicitud[precio_total] ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <!-- id="update" -->
                    <button type="submit" class="btn btn-info" id="update"> Actualizar <i class="entypo-plus"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    window.addEventListener("load", function() {
        var valor = document.getElementById('existencia').value;
        // console.log(valor);
        if (valor == 'SI') {
            // console.log('Muestra si');
            document.querySelectorAll('#existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('#no_existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        } else {
            // console.log('Muestra no');
            document.querySelectorAll('#no_existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('#existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        }
        var id = document.getElementById('id_material').value;
        console.log('ID_material: ' + id);
        fetch('control/detalle_material/detalle_material.php?id_detalle_material=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success === true && data.cantidad > 0) {
                    document.getElementById('cantidad_material').value = data.cantidad + ' ' + data.unidad_medida + ' restantes';
                    document.getElementById('cant_mat').value = data.cantidad;
                } else {
                    document.getElementById('cantidad_material').value = '';
                    alert("No tiene Stock disponible");
                }
            })
            .catch(error => console.error(error));
    });

    function borrarInput() {
        var input = event.target;
        var precio_input = document.getElementById('precio_unitario_sn');
        var precio_t_input = document.getElementById('precio_total');
        input.value = '';
        precio_input.value = '';
        precio_t_input.value = '';
    }
    var miInput = document.getElementById("cantidad_sn");
    miInput.addEventListener("click", borrarInput);

    const input = document.getElementById('precio_unitario_sn');
    const cantidad = document.getElementById('cantidad_sn');
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
            let cantidad = parseFloat(document.getElementById('cantidad_sn').value);
            let precio = parseFloat(this.value);
            console.log(cantidad + '+' + precio);
            let total = Math.round((cantidad * precio) * 100) / 100;
            console.log(total);
            document.getElementById('precio_total').value = total;
        }

    });
    jQuery(document).ready(function($) {
        $('.id_material').change(function() {
            var id = $(this).val();
            console.log('Material: ' + id);
            if (id !== '') {
                $.ajax({
                    type: "GET",
                    url: "control/detalle_material/detalle_material.php",
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
                        jAlert("No tiene Stock disponible", "Mensaje")
                    }
                })
            } else {
                console.log('seleccionar')
            }

        });

        function agregar() {
            // event.preventDefault();
            var id_detalle_material = $("#id_detalle_material").val();
            var existencia = $("#existencia").val();
            var unidad_medida_old = $('#unidad_medida_old').val();
            var descripcion_old = $('#descripcion_old').val();
            var id_material = $("#id_material").val();
            var cantidad_material = $("#cantidad_material").val();
            var cantidad_solicitada = parseFloat($("#cantidad_solicitada").val());
            var cantidad_solicitada_old = parseFloat($("#cantidad_solicitada_old").val());
            var cantidad_sn = parseFloat($("#cantidad_sn").val());
            var unidad_medida_sn = $("#unidad_medida_sn").val() != '' ? $("#unidad_medida_sn").val() : '';
            var descripcion_material = $("#descripcion_material").val() != '' ? $("#descripcion_material").val() : '';
            // var id_partida = parseFloat($("#id_partida").val());
            var precio_unitario_sn = $("#precio_unitario_sn").val() != '' ? $("#precio_unitario_sn").val() : 0;
            var precio_referencia = parseFloat($("#precio_total").val());
            $.ajax({
                type: "POST",
                url: "control/detalle_material/update_detalle_material.php",
                data: {
                    'id_detalle_material': id_detalle_material,
                    'existencia': existencia,
                    'unidad_medida_old': unidad_medida_old,
                    'descripcion_old': descripcion_old,
                    'id_material': id_material,
                    'cantidad_material': cantidad_material,
                    'cantidad_solicitada': cantidad_solicitada,
                    'cantidad_solicitada_old': cantidad_solicitada_old,
                    'cantidad_sn': cantidad_sn,
                    'unidad_medida_sn': unidad_medida_sn,
                    'descripcion_material': descripcion_material,
                    // 'id_partida': id_partida,
                    'precio_unitario_sn': precio_unitario_sn,
                    'precio_referencia': precio_referencia,
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
        $("#update").click(function() {
            agregar();
            event.preventDefault();
        });
    });
</script>