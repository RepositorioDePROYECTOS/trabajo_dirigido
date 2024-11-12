<?php

include("modelo/material.php");
include("modelo/detalle_material.php");

$id_solicitud_material = $_GET[id];
// revisado
// almacenar el id de la solicitud en los detalles de la solicitud


$registros_detalle_material = $bd->Consulta("SELECT * 
    FROM solicitud_material as sm  
    INNER JOIN detalle_material as dm ON sm.id_solicitud_material = dm.id_solicitud_material
    where sm.id_solicitud_material=$id_solicitud_material");
$registro_d = $bd->getFila($registros_detalle_material);
// print_r($registro_d);

?>


<h2>
    Editar partidas de la solicitud
    <a href="?mod=solicitud_material&pag=lista_solicitud_material" class="btn btn-primary btn-icon" style="float: right;margin-right: 5px;">
        Solicitudes Material<i class="entypo-pencil"></i>
    </a>
</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-body">
        <div class="row">
            <label for="unidad_solicitante" class="col-sm-1 control-label">Unidad Solicitante</label>
            <div class="col-sm-5">
                <input type="text" name="unidad_solicitante" id="unidad_solicitante" class="form-control required datepicker" value='<?php echo ($registro_d[unidad_solicitante] != null) ? utf8_encode($registro_d[unidad_solicitante]) : utf8_encode($registro_d[oficina_solicitante]); ?>' placeholder readonly />
            </div>
            <label for="nombre_solicitante" class="col-sm-1 control-label2 control-label">Cantidad Solicitada</label>
            <div class="col-sm-5">
                <input type="text" name="nombre_solicitante" id="nombre_solicitante" class="form-control" value='<?php echo utf8_encode($registro_d[nombre_solicitante]); ?>' readonly />
            </div>
        </div>
        <div class="row">
            <label for="justificativo" class="col-sm-1 control-label">Justificativo</label>
            <div class="col-sm-5">
                <input type="text" name="justificativo" id="justificativo" class="form-control required datepicker" value='<?php echo utf8_encode($registro_d[justificativo]); ?>' placeholder readonly />
            </div>
            <label for="objetivo_contratacion" class="col-sm-1 control-label2 control-label">Objetivo Contratacion</label>
            <div class="col-sm-5">
                <input type="text" name="objetivo_contratacion" id="objetivo_contratacion" class="form-control" value='<?php echo $registro_d[objetivo_contratacion]; ?>' readonly />
            </div>
        </div>
        <hr>
        <!-- <div class="row"> -->
        <div class="row">
            <?php
            //! Buscar los detalles de la solicitud
            $n = 1;
            $find_items = $bd->Consulta("SELECT id_detalle_material, descripcion, id_partida FROM detalle_material WHERE id_solicitud_material = $id_solicitud_material");
            while ($find = $bd->getFila($find_items)) {
                $partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
            ?>
                <input type='hidden' name='<?php echo "id_detalle_material_" . $n ?>' id='<?php echo "id_detalle_material_" . $n ?>' value='<?php echo $find[id_detalle_material]; ?>'>
                <label for="descripcion" class="col-sm-1 control-label">Descripcion</label>
                <div class="col-sm-5">
                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $find[descripcion] ?>" class="form-control required" readonly>
                </div>
                <label class="col-sm-1 control-label2 control-label">Partidas</label>
                <div class="col-sm-5">
                    <select name="<?php echo 'id_partida_' . $n ?>" id="<?php echo 'id_partida_' . $n ?>" class="form-control required select2">
                        <?php
                        while ($partida = $bd->getFila($partidas)) {

                            $selected = ($partida['id_partida'] == $find[id_partida]) ? 'selected' : ''; // Agregar 'selected' si el id_partida es 10
                            echo utf8_encode("<option value='$partida[id_partida]' $selected>$partida[codigo_partida] - $partida[nombre_partida]</option>");
                        }
                        ?>
                    </select>
                </div>
            <?php
                $n++;
            }
            ?>
            <input type="hidden" name="id_solicitud_material" id="id_solicitud_material" value="<?php echo $id_solicitud_material; ?>">
            <input type="hidden" name="tamanio" id="tamanio" value="<?php echo $n; ?>">
        </div>
        <hr>
        <div class="row">
            <button type="button" class="btn btn-success pull-right btn-icon" id="enviarPresupuesto" data-dismiss="modal">Enviar <i class='entypo-pencil'></i></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#enviarPresupuesto').click(function(e) {

            let id_solicitud_material = $('#id_solicitud_material').val();
            console.log(id_solicitud_material);
            let array = [];
            let tamanio = parseInt($('#tamanio').val());
            console.log("tamanio: ", tamanio);
            let contador = 1;

            var form_data = new FormData();
            form_data.append('id_solicitud_material', id_solicitud_material);
            for (let contador = 1; contador <= tamanio; contador++) {
                let detalle_id = '#id_detalle_material_' + contador;
                let select_detalles = $(detalle_id).val();
                let selectId = '#id_partida_' + contador;
                let selectedValue = $(selectId).val(); // Obtener el valor seleccionado del <select>
                form_data.append('partidas[]', select_detalles + '-' + selectedValue);
                array.push({
                    id_detalle_material: select_detalles,
                    id_partida: selectedValue
                });
            }
            console.log("informacion de los detalles", {
                array
            });

            form_data.append('edit[]', array);
            var formDataValues = {};

            // Iterar a través de las entradas del FormData
            for (let pair of form_data.entries()) {
                formDataValues[pair[0]] = pair[1];
            }

            // Imprimir el objeto con los valores en la consola
            console.log("Valores del FormData:", formDataValues);
            $.ajax({
                url: 'control/solicitud_material/editar_partidas.php', // Ruta al controlador PHP
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Manejar la respuesta del controlador PHP
                    if (response.startsWith("Solicitud")) {
                        jAlert("Solicitud despachada con exito", "Approval", function(
                            resp) {
                            window.location.reload();
                        });
                    } else {
                        jAlert(response, "Mensaje")

                    }

                },
                error: function(xhr, status, error) {
                    // Manejar el error de la solicitud Ajax
                    console.error(error);
                }
            });
        });

    });
</script>