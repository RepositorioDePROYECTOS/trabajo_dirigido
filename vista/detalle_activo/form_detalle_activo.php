<?php

$id_solicitud_activo = $_GET[id_solicitud_activo];

// almacenar el id de la solicitud en los detalles de la solicitud
// $registros_m =  $bd->Consulta("select * from activo");
$partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
$registros_s = $bd->Consulta("SELECT * FROM detalle_activo WHERE id_solicitud_activo=$id_solicitud_activo");
$registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud_activo");
$registro_sol = $bd->getFila($registros_solicitud);
$unidad_de_medidas = $bd->Consulta("SELECT descripcion FROM unidad_de_medida ORDER BY descripcion");
$sum_total = $bd->Consulta("SELECT SUM(precio_total) as total FROM detalle_activo WHERE id_solicitud_activo = $id_solicitud_activo");
$s_total = $bd->getFila($sum_total);
?>

<style>
    .d-none {
        display: none;
    }
</style>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    Detalle de la solicitud <?php if($registro_sol[existencia_activo] == 'NO'){echo " Formulario CM-02";}?>
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <h4>Objetivo: <strong><?php echo utf8_encode($registro_sol[objetivo_contratacion]);?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($registro_sol[justificativo]);?></strong></h4>
        <h4>Fecha de solicitud: <strong><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo utf8_encode($registro_sol[nombre_solicitante]); ?></strong></h4>
        <h4>Existencia de activo: <strong><?php echo utf8_encode($registro_sol[existencia_activo]) ?></strong></h4>
        <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->
        <input type="hidden" name="existencia" id="existencia" value="<?php echo utf8_encode($registro_sol[existencia_activo]) ?>">
        <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->
        <form name="frm_detalle_activo" id="frm_detalle_activo" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">
            <input type="hidden" id="id_solicitud_activo" name="$id_solicitud_activo" value="<?php echo $id_solicitud_activo; ?>">
            <div class="row" id="existe" style="display: none;">

                <input type="hidden" name="unidad_medida" id="unidad_medida">
                <input type="hidden" name="precio_unitario" id="precio_unitario">
                <input type="hidden" name="cant_mat" id="cant_mat">
                <input type="hidden" name="total_usado" id="total_usado" value="<?php echo $s_total[total] ;?>">
                <div class="col-md-3">
                    <select name="id_activo" id="id_activo" class=" id_activo form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
                        while ($registro_m = $bd->getFila($registros_m)) {
                            echo utf8_encode("<option value='$registro_m[id_activo]'>$registro_m[descripcion] ($registro_m[unidad_medida])</option>");
                        }
                        ?>

                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="cantidad_activo" id="cantidad_activo" class="form-control" placeholder="Cantidad de activo existente" readonly />
                </div>
                <div class="col-md-2">
                    <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control enteros" placeholder="Cantidad a solicitar" min="1" />
                </div>
            </div>
            <div id="no_existe" style="display: none;">
                
                <div class="form-group">
                    <label for="descripcion_activo" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-6">
                        <textarea name="descripcion_activo" id="descripcion_activo" rows="4" class="form-control required text uppercase" placeholder="Escribir descripcion del activo..."></textarea>
                        <b>Sugerencia: <span id="results" class="text-muted"></span> </b> <br><br>
                        <div class="table-responsive" style="height:100px">
                            <ul id="tableSugerencias">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cantidad_sn" class="col-sm-3 control-label">Cantidad Solicitada</label>
                    <div class="col-sm-6">
                        <input type="text" name="cantidad_sn" id="cantidad_sn" class="form-control" placeholder="Introducir la cantidad solicitada">
                    </div>
                </div>
                <div class="form-group">
                    <label for="unidad_medida_sn" class="col-sm-3 control-label">Unidad de Medida</label>
                    <div class="col-sm-6">
                        <select name="unidad_medida_sn" id="unidad_medida_sn" class="form-control select2" placeholder="Introducir Unidad medida.">
                            <option value="" selected>--SELECCIONE--</option>
                            <?php while ($unidad_medida = $bd->getFila($unidad_de_medidas)) { ?>
                                <option value="<?php echo utf8_encode(strtoupper($unidad_medida['descripcion'])); ?>"><?php echo utf8_encode(strtoupper($unidad_medida['descripcion'])); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="id_partida" class="col-sm-3 control-label">Partida</label>
                    <div class="col-sm-6">
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
                    <label for="precio_unitario_sn" class="col-sm-3 control-label">Precio Unitario</label>
                    <div class="col-sm-6">
                        <input type="text" name="precio_unitario_sn" id="precio_unitario_sn" class="form-control decimales" placeholder="Introducir precio unitario..." />
                    </div>
                </div>
                <div class="form-group">
                    <label for="precio_total" class="col-sm-3 control-label">Precio Total</label>
                    <div class="col-sm-6">
                        <input type="number" min="0" max="10000" name="precio_total" id="precio_total" class="form-control decimales" readonly />
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-green btn-icon pull-right" id="agregar">
                Agregar <i class="entypo-plus"></i>
            </button>
        </form>
    </div>
    <h3>Detalle de activos</h3>
    <div id="detalle_activos" class="col-sm-12 table-responsive">
        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 5%;">Nro</th>
                    <th style="width: 25%;">Descripci&oacute;n</th>
                    <th style="width: 15%;">Unidad de medida</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 15%;">Precio Unitario</th>
                    <?php if ($registro_sol[existencia_activo] == 'NO') { ?>
                        <th style="width: 15%;">Precio Total</th>
                    <?php } ?>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbl_body">
                <!-- realizar una consulta de acuerdo a la solicitud si tiene activos $solicitud->activos->count() e imprimir aqui -->
                <?php
                while ($registro_s = $bd->getFila($registros_s)) {
                    $n++;
                    echo "<tr style='text-align: center;'>";
                    echo utf8_encode(
                        "
                        <td>$n</td>
                        <td>$registro_s[descripcion]</td>
                        <td>$registro_s[unidad_medida]</td>
                        <td>$registro_s[cantidad_solicitada]</td>
                        <td>$registro_s[precio_unitario]</td>"
                    );
                    if ($registro_sol[existencia_activo] == 'NO')
                        echo "<td>$registro_s[precio_total]</td></td>";
                    echo "<td>";
                    echo utf8_encode("<a href='?mod=detalle_activo&pag=editar_detalle_activo&id=$registro_s[id_detalle_activo]' class='btn btn-success btn-icon btn-xs' style='float: right;'>Editar <i class='entypo-pencil'></i></a><br>");
                    if ($registro_sol[existencia_activo] == 'SI') {
                        echo "<br>";
                    }
                    echo utf8_encode("<a href='control/detalle_activo/eliminar_detalle_activo.php?id_detalle_activo=$registro_s[id_detalle_activo]' class='eliminar_lista btn btn-red btn-icon btn-xs' style='float: right;'>Quitar <i class='entypo-cancel'></i></a><br>");
                    if ($registro_sol[existencia_activo] == 'NO') {
                        echo utf8_encode("<a href='?mod=especificacion_activo&pag=index&id=$registro_s[id_detalle_activo]' class='btn btn-info btn-icon btn-xs' style='float: right;'>Especificar <i class='entypo-plus'></i></a>");
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
            <!-- <a href='?mod=detalle_activo&pag=editar_detalle_activo&id=$registro_s[id_detalle_activo]' class='btn btn-success btn-icon btn-xs' style='float: right; margin-right: 5px; margin-bottom: 10px; margin-top: 20px;'>Editar <i class='entypo-pencil'></i></a><br> -->
        </table>
    </div>

</div>

<script type="text/javascript">
    let sugerencias = [];
    let indice_sugerencias = 0;
    const inputText = document.getElementById('descripcion_activo');
    const resultsSpan = document.getElementById('results');
    const tableSugerencias = document.getElementById('tableSugerencias');
    inputText.addEventListener('input', handleInput);
    inputText.addEventListener('keydown', handleKeys);

    function handleInput() {
        const inputValue = inputText.value;
        console.log("Se pulso la siguiente frase: " + inputValue);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'control/detalle_activo/buscar_detalles.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                if (response.success === true) {
                    let resultado = response.message;
                    let message = "";
                    if (resultado.length == 0) {
                        message = "No hay sugerencias";
                        sugerencias = [];
                    } else {
                        console.log(resultado.length, 'prueba')
                        sugerencias = resultado;
                        message = resultado[0].descripcion
                    }
                    indice_sugerencias = 0;
                    // Hacer algo con el mensaje, como mostrarlo en el span
                    resultsSpan.textContent = message;
                    llenarTabla();
                } else {
                    console.log('Error en el controlador:', response.message);
                }
            } else {
                // resultsSpan.textContent = 'No se encontraron resultados';
                console.log('No se encontraron resultados');
            }
        };
        xhr.send('detalle_activo=' + encodeURIComponent(inputValue));
    }

    function handleKeys(e) {
        let palabras_escritas = [];
        let prediccion = "";
        let textPredecido = "";
        if (e.key === 'Tab') {
            e.preventDefault();
            console.log('tab')
            console.log(inputText.value)
            console.log(resultsSpan.innerText)
            palabras_escritas = inputText.value.split(' ');
            // console.log(palabras_escritas, 'hola')
            prediccion = resultsSpan.innerText;
            // console.log(prediccion, 'pre')
            if (prediccion != 'No hay sugerencias') {
                textPredecido = prediccion.slice(palabras_escritas[palabras_escritas.length - 1].length, prediccion.length);
            }
            // console.log(textPredecido, 'hhh')
            inputText.value = inputText.value + textPredecido;
            sugerencias = [];
            indice_sugerencias = 0;
            resultsSpan.innerText = "No hay sugerencias"
            llenarTabla()
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (sugerencias[indice_sugerencias - 1]) {
                resultsSpan.innerText = sugerencias[indice_sugerencias - 1].descripcion;
                indice_sugerencias--
                llenarTabla()

            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (sugerencias[indice_sugerencias + 1]) {
                resultsSpan.innerText = sugerencias[indice_sugerencias + 1].descripcion;
                indice_sugerencias++
                llenarTabla()

            }
        }
    }

    function llenarTabla() {
        let cadena = "";
        sugerencias.forEach((sug, index) => {
            cadena += `<li class="${indice_sugerencias != index? 'text-muted':''}">${sug.descripcion}</li>`
        })
        tableSugerencias.innerHTML = cadena
    }
    window.addEventListener("load", function() {
        var valor = document.getElementById('existencia').value;
        console.log(valor);
        if (valor == 'SI') {
            console.log('Muestra si');
            document.querySelectorAll('#existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('#no_existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        } else {
            console.log('Muestra no');
            document.querySelectorAll('#no_existe').forEach(function(el) {
                el.style.display = 'block';
            });
            document.querySelectorAll('#existe').forEach(function(el) {
                el.style.display = 'none';
            });
            // document.getElementById('registrar').disabled = false;
        }
    });
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

    //     var existencia = $('#existencia').val();
    //     var id_solicitud_activo = $("#id_solicitud_activo").val();
    //     var id_activo = $("#id_activo").val();
    //     var cantidad_solicitada = $("#cantidad_solicitada").val() != '' ? parseFloat($("#cantidad_solicitada").val()) : 0;
    //     var unidad_medida = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
    //     var precio_unitario = $("#precio_unitario").val() != '' ? $("#precio_unitario").val() : 0;
    //     var cantidad_sn = $('#cantidad_sn').val() != '' ? parseFloat($('#cantidad_sn').val()) : 0;
    //     var unidad_medida_sn = $('#unidad_medida_sn').val() != '' ? $('#unidad_medida_sn').val() : '';
    //     var descripcion_activo = $("#descripcion_activo").val() != '' ? $("#descripcion_activo").val() : '';
    //     var id_partida         = $("#id_partida").val() != '' ? $("#id_partida").val() : '';
    //     var precio_unitario_sn = $('#precio_unitario_sn').val() != '' ? parseFloat($('#precio_unitario_sn').val()) : 0;
    //     var precio_referencia = $('#precio_total').val() != '' ? parseFloat($('#precio_total').val()) : 0;
    document.getElementById("agregar").addEventListener("click", function() {
        agregar_detalles();

        function agregar_detalles() {
            var id_solicitud_activo = document.getElementById("id_solicitud_activo").value;
            var id_activo = document.getElementById("id_activo").value;
            var descripcion_activo = document.getElementById("descripcion_activo").value !== '' ? document.getElementById("descripcion_activo").value.toUpperCase() : '';
            var unidad_medida = document.getElementById("unidad_medida").value !== '' ? document.getElementById("unidad_medida").value.toUpperCase() : '';
            var unidad_medida_sn = document.getElementById("unidad_medida_sn").value.toUpperCase() !== '' ? document.getElementById("unidad_medida_sn").value : '';
            var precio_unitario = document.getElementById("precio_unitario").value !== '' ? document.getElementById("precio_unitario_sn").value : 0;
            var precio_unitario_sn = document.getElementById("precio_unitario_sn").value !== '' ? document.getElementById("precio_unitario_sn").value : 0;
            var cantidad_solicitada = parseFloat(document.getElementById("cantidad_solicitada").value);
            var cantidad_sn = parseFloat(document.getElementById("cantidad_sn").value);
            // var id_partida = document.getElementById("id_partida").value;
            var precio_referencia = parseFloat(document.getElementById("precio_total").value);
            var existencia = document.getElementById("existencia").value;
            var total_usado = document.getElementById("total_usado").value !== '' ? document.getElementById("total_usado").value : 0;
            var data = [{
                    name: "id_solicitud_activo",
                    value: id_solicitud_activo
                },
                {
                    name: "id_activo",
                    value: id_activo
                },
                {
                    name: "descripcion_activo",
                    value: descripcion_activo
                },
                {
                    name: "unidad_medida",
                    value: unidad_medida
                },
                {
                    name: "unidad_medida_sn",
                    value: unidad_medida_sn
                },
                {
                    name: "precio_unitario",
                    value: precio_unitario
                },
                {
                    name: "precio_unitario_sn",
                    value: precio_unitario_sn
                },
                {
                    name: "cantidad_solicitada",
                    value: cantidad_solicitada
                },
                {
                    name: "cantidad_sn",
                    value: cantidad_sn
                },
                {
                    name: "precio_referencia",
                    value: precio_referencia
                },
                {
                    name: "existencia",
                    value: existencia
                },
                {
                    name: "total_usado",
                    value: total_usado
                },
            ];

            console.table(data);

            if (existencia === 'SI') {
                if (id_activo === '' || cantidad_solicitada === '') {
                    jAlert("Seleccione o introduzca activo.", "Mensaje");
                    return;
                }
                if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {
                    jAlert("Introduzca una cantidad válida.", "Mensaje");
                    document.getElementById("cantidad_solicitada").focus();
                    return;
                }
            } else {
                // if (id_partida === '') {
                //     jAlert("Seleccione una partida.", "Mensaje");
                //     document.getElementById("id_partida").focus();
                //     return;
                // }
            }

            var url = "control/detalle_activo/insertar_detalle_activo.php";
            var data = new URLSearchParams();
            data.append('id_solicitud_activo', id_solicitud_activo);
            data.append('id_activo', id_activo);
            // data.append('id_partida', id_partida);
            data.append('descripcion_activo', descripcion_activo);
            data.append('unidad_medida', unidad_medida);
            data.append('unidad_medida_sn', unidad_medida_sn);
            data.append('cantidad_solicitada', cantidad_solicitada);
            data.append('cantidad_sn', cantidad_sn);
            data.append('precio_unitario', precio_unitario);
            data.append('precio_unitario_sn', precio_unitario_sn);
            data.append('precio_referencia', precio_referencia);
            data.append('existencia', existencia);
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
        // alert("Agregar_detalles");
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

        // function agregar() {
        //     var existencia = $('#existencia').val();

        //     var id_solicitud_activo = $("#id_solicitud_activo").val();
        //     var id_activo = $("#id_activo").val();
        //     var cantidad_solicitada = $("#cantidad_solicitada").val() != '' ? parseFloat($("#cantidad_solicitada").val()) : 0;
        //     var unidad_medida = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
        //     var precio_unitario = $("#precio_unitario").val() != '' ? $("#precio_unitario").val() : 0;

        //     var cantidad_sn = $('#cantidad_sn').val() != '' ? parseFloat($('#cantidad_sn').val()) : 0;
        //     var unidad_medida_sn = $('#unidad_medida_sn').val() != '' ? $('#unidad_medida_sn').val() : '';
        //     var descripcion_activo = $("#descripcion_activo").val() != '' ? $("#descripcion_activo").val() : '';
        //     var id_partida         = $("#id_partida").val() != '' ? $("#id_partida").val() : '';
        //     var precio_unitario_sn = $('#precio_unitario_sn').val() != '' ? parseFloat($('#precio_unitario_sn').val()) : 0;
        //     var precio_referencia = $('#precio_total').val() != '' ? parseFloat($('#precio_total').val()) : 0;
        //     console.table([
        //     {
        //         existencia: existencia,
        //         id_solicitud_activo: id_solicitud_activo,
        //         id_activo: id_activo,
        //         cantidad_solicitada: cantidad_solicitada,
        //         unidad_medida: unidad_medida,
        //         precio_unitario: precio_unitario,
        //         cantidad_sn: cantidad_sn,
        //         unidad_medida_sn: unidad_medida_sn,
        //         descripcion_activo: descripcion_activo,
        //         id_partida: id_partida,
        //         precio_unitario_sn: precio_unitario_sn,
        //         precio_referencia: precio_referencia
        //     }
        //     ]);
        //     if (existencia == 'SI') {
        //         if (id_activo == '' || cantidad_solicitada == '') {
        //             jAlert("Seleccione o introduzca activo.", "Mensaje");
        //         } else {
        //             if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {

        //                 jAlert("Introduzca una cantidad v&aacute;lida.", "Mensaje", function(reso) {
        //                     $("#cantidad_solicitada").focus();
        //                 });
        //             }
        //         }
        //     } else {
        //         if (precio_referencia <= 0) {
        //             jAlert("Introduzca todos los datos.", "Mensaje", function(reso) {
        //                 $("#precio_total").focus();
        //             });
        //         }
        //     }
        //     $.ajax({
        //         type: "POST",
        //         url: "control/detalle_activo/insertar_detalle_activo.php",
        //         data: {
        //             'existencia': existencia,

        //             'id_solicitud_activo': id_solicitud_activo,
        //             'id_activo': id_activo,
        //             'cantidad_solicitada': cantidad_solicitada,
        //             'unidad_medida': unidad_medida,
        //             'precio_unitario': precio_unitario,
        //             'cantidad_sn': cantidad_sn,
        //             'unidad_medida_sn': unidad_medida_sn,
        //             'descripcion_activo': descripcion_activo,
        //             'id_partida': id_partida,
        //             'precio_unitario_sn': precio_unitario_sn,
        //             'precio_referencia': precio_referencia,
        //         }
        //     }).done(function(response) {
        //         var data = JSON.parse(response);
        //         console.log(response)
        //         if (data.success === true) {
        //             window.location.reload();
        //         } else {
        //             jAlert(data.message, "Mensaje")
        //         }
        //     }).fail(function(response) {
        //         console.log(response)
        //     })
        // }

        // $("#agregar").click(function() {
        //     agregar();
        // });

        $('.id_activo').change(function() {
            var id = $(this).val();
            if (id !== '') {
                $.ajax({
                    type: "GET",
                    url: "control/detalle_activo/detalle_activo.php",
                    data: {
                        'id_detalle_activo': id
                    }
                }).done(function(response) {
                    var data = JSON.parse(response);

                    if (data.success === true && data.cantidad > 0) {
                        $('#cantidad_activo').val(data.cantidad + ' ' + data.unidad_medida +
                            ' restantes')
                        $('#cant_mat').val(data.cantidad);
                    } else {
                        $('#cantidad_activo').val('')
                        jAlert("No tiene Stock disponible", "Mensaje")
                    }
                })
            } else {
                console.log('seleccionar')
            }

        });
        $("#cantidad_solicitada").keyup(function(e) {
            var key = parseFloat($('#cantidad_solicitada').val());
            var cantidad_activo = $('#cant_mat').val() != '' ? parseFloat($('#cant_mat').val()) : 0;
            console.log(key, cantidad_activo)
            if (cantidad_activo > 0) {
                if (key >= cantidad_activo) {
                    jAlert("No Puede superar la cantidad existente", "Mensaje")
                }
            }

        });
    });
</script>