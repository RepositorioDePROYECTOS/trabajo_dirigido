<?php

include("modelo/material.php");
include("modelo/detalle_material.php");

$id_solicitud_material = $_GET[id_solicitud_material];

// almacenar el id de la solicitud en los detalles de la solicitud

$detalle_material = new detalle_material();
## Parametros de datos para seleccion
$registros_m =  $bd->Consulta("SELECT * from material");
$partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");

## Datos de la Solicitud
$registros_s = $bd->Consulta("SELECT * FROM detalle_material WHERE id_solicitud_material=$id_solicitud_material");
$registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud_material");
$registro_sol = $bd->getFila($registros_solicitud);
$unidad_de_medidas = $bd->Consulta("SELECT descripcion FROM unidad_de_medida ORDER BY descripcion");
// echo var_dump($registro_sol);
$sum_total = $bd->Consulta("SELECT SUM(precio_total) as total FROM detalle_material WHERE id_solicitud_material = $id_solicitud_material");
$s_total = $bd->getFila($sum_total);
?>

<style>
    .d-none {
        display: none;
    }
</style>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
    Detalle de la solicitud <?php if ($registro_sol[existencia_material] == 'NO') {
                                echo " Formulario CM-02";
                            } ?>
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <h4>Objetivo: <strong><?php echo utf8_encode($registro_sol[objetivo_contratacion]); ?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($registro_sol[justificativo]); ?></strong></h4>
        <h4>Fecha de solicitud: <strong><?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo utf8_encode($registro_sol[nombre_solicitante]); ?></strong></h4>
        <h4>Existencia de material: <strong><?php echo utf8_encode($registro_sol[existencia_material]) ?></strong></h4>

        <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->
        <input type="hidden" name="existencia" id="existencia" value="<?php echo utf8_encode($registro_sol[existencia_material]) ?>">
        <!-- Para buscar en el JS para mostrar el formulario de Existencia o No Existencia -->

        <form name="frm_detalle_material" id="frm_detalle_material" method="post" role="form" class="validate_venta form-horizontal form-groups-bordered">

            <input type="hidden" id="id_solicitud_material" name="$id_solicitud_material" value="<?php echo $id_solicitud_material; ?>">
            <input type="hidden" name="unidad_medida" id="unidad_medida">
            <input type="hidden" name="cant_mat" id="cant_mat">
            <input type="hidden" name="precio_unitario" id="precio_unitario">
            <input type="hidden" name="total_usado" id="total_usado" value="<?php echo $s_total[total]; ?>">
            <!-- <div class="form-group bg-oferta">
                <label for="material" class="col-sm-1 control-label">Material</label>
                <div class="col-sm-12"> -->
            <div class="row" id="existe" style="display: none;">
                <!-- <div class="col-md-3">
                    <select name="id_material" id="id_material" class=" id_material form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
                        // while ($registro_m = $bd->getFila($registros_m)) {
                        // echo utf8_encode("<option value='$registro_m[id_material]'>$registro_m[codigo]-$registro_m[descripcion] ($registro_m[unidad_medida])</option>");
                        // }
                        ?>

                    </select>
                </div> -->
                <div class="col-md-3">
                    <select name="id_material" id="id_material" class="id_material form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                    </select>
                </div>
                <div class="col-md-3" id="key_cantidad">
                    <input type="text" name="cantidad_material" id="cantidad_material" class="form-control" placeholder="Cantidad de material existente" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control decimales" placeholder="Cantidad a solicitar" min="1" step="any" />

                </div>
            </div>
            <div id="no_existe" style="display: none;">

                <div class="form-group">
                    <label for="descripcion_material" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-6" width="100%">
                        <textarea name="descripcion_material" id="descripcion_material" rows="4" class="form-control required text uppercase" placeholder="Escribir descripcion del material..."></textarea>
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
    <div id="detalle_materiales" class="col-sm-12 table-responsive">
        <h3>Materiales Resgistrados</h3>
        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 5%;">Nro</th>
                    <th style="width: 25%;">Descripci&oacute;n</th>
                    <th style="width: 15%;">Unidad de medida</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 15%;">Precio Unitario</th>
                    <?php if ($registro_sol[existencia_material] == 'NO') { ?>
                        <th style="width: 15%;">Precio Total</th>
                    <?php } ?>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbl_body">
                <!-- realizar una consulta de acuerdo a la solicitud si tiene materiales $solicitud->materiales->count() e imprimir aqui -->
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
                    if ($registro_sol[existencia_material] == 'NO')
                        echo "<td>$registro_s[precio_total]</td></td>";
                    echo "<td align='center'>";
                    echo utf8_encode("<a href='?mod=detalle_material&pag=editar_detalle_material&id=$registro_s[id_detalle_material]' class='btn btn-success btn-icon btn-xs' style='float: right;'>Editar <i class='entypo-pencil'></i></a><br>");

                    if ($registro_sol[existencia_material] == 'SI') {
                        echo "<br>";
                    }

                    echo utf8_encode("<a href='control/detalle_material/eliminar_detalle_material.php?id_detalle_material=$registro_s[id_detalle_material]' class='eliminar_lista btn btn-red btn-icon btn-xs' style='float: right;'>Quitar <i class='entypo-cancel'></i></a><br>");

                    if ($registro_sol[existencia_material] == 'NO') {
                        echo utf8_encode("<a href='?mod=especificacion_material&pag=index&id=$registro_s[id_detalle_material]' class='btn btn-info btn-icon btn-xs' style='float: right;'>Especificar <i class='entypo-plus'></i></a>");
                    }
                    echo "</td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    let sugerencias = [];
    let indice_sugerencias = 0;
    const inputText = document.getElementById('descripcion_material');
    const resultsSpan = document.getElementById('results');
    const tableSugerencias = document.getElementById('tableSugerencias');
    inputText.addEventListener('input', handleInput);
    inputText.addEventListener('keydown', handleKeys);

    function handleInput() {
        const inputValue = inputText.value;
        console.log("Se pulso la siguiente frase: " + inputValue);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'control/detalle_material/buscar_detalles.php');
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
                    llenarTabla()

                } else {
                    console.log('Error en el controlador:', response.message);
                }
            } else {
                // resultsSpan.textContent = 'No se encontraron resultados';
                console.log('No se encontraron resultados');
            }
        };
        xhr.send('detalle_material=' + encodeURIComponent(inputValue));
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

    document.getElementById("agregar").addEventListener("click", function() {
        agregar_detalles();
        // alert("Agregar_detalles");
    });

    function agregar_detalles() {
        var id_solicitud_material = document.getElementById("id_solicitud_material").value;
        // Enviar endopoint
        // var id_material = document.getElementById("id_material").value;
        var selectElement = document.getElementById("id_material");

        // Get the selected option
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var item = JSON.parse(selectedOption.getAttribute('data-info'));
        console.log("Capturado por el select: ", item);
        // Enviar endopoint
        if (item !== null) {
            var costo_unitario = item.SaldoCosto / item.saldoCantidad;
            if (costo_unitario < 0) {
                costo_unitario = costo_unitario * -1;
            }
            console.log("si");
            var descripcion_material = item.nombre !== '' ? item.nombre : '';
            var unidad_medida = item.unidad !== '' ? item.unidad : '';
            var id_material = item.codigo;
            var precio_unitario = costo_unitario != 0 ? costo_unitario : 0;
        } else {
            console.log("no");
            var descripcion_material = '';
            var unidad_medida = '';
            var id_material = '';
            var precio_unitario = 0;
        }
        // Enviar endopoint
        var nombre_sn = document.getElementById("descripcion_material").value.toUpperCase() !== '' ? document.getElementById("descripcion_material").value : '';
        var unidad_medida_sn = document.getElementById("unidad_medida_sn").value.toUpperCase() !== '' ? document.getElementById("unidad_medida_sn").value : '';
        var precio_unitario_sn = document.getElementById("precio_unitario_sn").value !== '' ? document.getElementById("precio_unitario_sn").value : 0;
        var cantidad_solicitada = parseFloat(document.getElementById("cantidad_solicitada").value);
        var cantidad_sn = parseFloat(document.getElementById("cantidad_sn").value);
        var precio_referencia = parseFloat(document.getElementById("precio_total").value);
        var existencia = document.getElementById("existencia").value;
        var total_usado = document.getElementById("total_usado").value !== '' ? document.getElementById("total_usado").value : 0;
        var data = [{
                name: "id_solicitud_material",
                value: id_solicitud_material
            },
            {
                name: "id_material",
                value: id_material
            },
            {
                name: "descripcion_material",
                value: descripcion_material
            },
            {
                name: "nombre_sn",
                value: nombre_sn
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
            }
        ];

        console.table(data);

        if (existencia === 'SI') {
            if (id_material === '' || cantidad_solicitada === '') {
                jAlert("Seleccione o introduzca material.", "Mensaje");
                return;
            }
            if (isNaN(cantidad_solicitada) || cantidad_solicitada <= 0) {
                jAlert("Introduzca una cantidad válida.", "Mensaje");
                document.getElementById("cantidad_solicitada").focus();
                return;
            }
        }

        var url = "control/detalle_material/insertar_detalle_material.php";
        var data = new URLSearchParams();
        data.append('id_solicitud_material', id_solicitud_material);
        data.append('id_material', id_material);
        data.append('descripcion_material', descripcion_material);
        data.append('descripcion_material_sn', nombre_sn);
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

        $.ajax({
            url: 'http://192.168.16.30:3001/datos',
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    var data = response.data;
                    var select = $('#id_material');
                    select.empty();
                    // Añadir una opción por defecto
                    select.append($('<option>', {
                        value: '',
                        text: 'Seleccione un material'
                    }));

                    data.forEach(function(item) {
                        // console.log(item)
                        var cantidadRedondeada = Math.round(item.saldoCantidad);
                        var option = $('<option></option>')
                            .val(item.codigo)
                            .text(`${item.codigo} - ${item.nombre} - Unidad: ${item.unidad} - Cantidad: ${cantidadRedondeada}`)
                            .attr('data-info', JSON.stringify(item));
                        select.append(option);
                    });
                } else {
                    alert('No hay datos disponibles');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                alert('Ocurrió un error al obtener los datos');
            }
        });

        $('#id_material').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var item = selectedOption.data('info');
            console.log("Recuperados: ", item);
            if (item) {
                $('#codigoInput').val(item.codigo);
                $('#nombreInput').val(item.nombre);
                $('#unidadInput').val(item.unidad);
                var cantidadRedondeada = Math.round(item.saldoCantidad);
                $('#cantidadInput').val(cantidadRedondeada);
                $('#cantidad_material').val(cantidadRedondeada + ' ' + item.unidad + ' restantes');
                $('#cant_mat').val(cantidadRedondeada);
            }
        });

        $("#cantidad_solicitada").keyup(function(e) {
            var key = parseFloat($('#cantidad_solicitada').val());
            var cantidad_material = $('#cant_mat').val() != '' ? parseFloat($('#cant_mat').val()) : 0;
            console.log(key, cantidad_material);
            if (cantidad_material > 0) {
                if (key >= cantidad_material) {
                    jAlert("No Puede superar la cantidad existente", "Mensaje");
                }
            }
        });

    });
</script>