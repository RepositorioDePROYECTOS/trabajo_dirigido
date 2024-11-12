<?php

include("modelo/material.php");
include("modelo/detalle_material.php");
    
$id_detalle_material = $_GET[id_detalle_material];
$id_solicitud_material = $_GET[id_solicitud_material];

// almacenar el id de la solicitud en los detalles de la solicitud


$registros_detalle_material= $bd->Consulta("select * from detalle_material where id_detalle_material=$id_detalle_material");
$registro_d = $bd->getFila($registros_detalle_material);

?>


<h2>Editar cantidad de la solicitud</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-body">
        <div class="row">
            <label for="descripcion" class="col-sm-2 control-label">Descripción</label>
            <div class="col-sm-4">
                <input type="text" name="descripcion" id="descripcion" class="form-control required datepicker"
                 value='<?php echo utf8_encode($registro_d[descripcion]); ?>' placeholder readonly />
            </div>
            <label for="cantidad_solicitada" class="col-sm-3 control-label2 control-label">Cantidad Solicitada</label>
            <div class="col-sm-3">
                <input type="number" name="cantidad_solicitada" id="cantidad_solicitada"
                    class="form-control"
                    value='<?php echo $registro_d[cantidad_solicitada];?>' readonly />
            </div>
        </div>
        <hr>
        <div class="row">
            <label for="cantidad_despachada" class="col-sm-2 control-label2 control-label">Cantidad a despachar</label>
            <div class="col-sm-3">
                <input type="hidden" name="id_detalle_material" id="id_detalle_material"
                    value="<?= $id_detalle_material; ?>" />
                <input type="hidden" name="id_solicitud_material" id="id_solicitud_material"
                    value="<?= $id_solicitud_material; ?>" />
                <input type="text" name="cantidad_despachada" id="cantidad_despachada"
                    class="form-control decimales"
                    value='<?php echo floatval($registro_d[cantidad_despachada]);?>' />
            </div>
        </div>
        <hr>
        <div class="form-group">
            <?php if($_SESSION[nivel] == 'ALMACENERO'){ ?>
            <div class="col-sm-12">
                <button type="button" class="btn btn-green btn-icon pull-right" style="margin-left:5px;" id="editar">
                    Editar <i class="entypo-pencil"></i>
                </button>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {

    function editar() {
        var id_detalle_material = $("#id_detalle_material").val();
        var id_solicitud_material = $("#id_solicitud_material").val();
        var cantidad_despachada = parseFloat($("#cantidad_despachada").val());
        if (isNaN(cantidad_despachada) || cantidad_despachada < 0) {
            jAlert("Introduzca una cantidad v&aacute;lida.", "Mensaje", function(reso) {
                $("#cantidad_despachada").focus();
            });
        } else {
            $.ajax({
                type: "POST",
                url: "control/detalle_material/editar_detalle_material.php",
                data: {
                    'id_detalle_material': id_detalle_material,
                    'cantidad_despachada': cantidad_despachada,
                }
            }).done(function(response) {
                var data = JSON.parse(response);
                console.log(response)
                if (data.success === true) {
                    jQuery("#modal_editar_detalle").modal('hide');


                    var param = "?mod=solicitud_material&pag=detalle_material&id_solicitud_material="+id_solicitud_material;
                    console.log(param);
                    var dir = "modal_index_ajax.php" + param;

                    jQuery("#modal_solicitud_material .modal-body").load(dir, function(res) {
                        if (res) {
                            var titulo = jQuery('#modal_solicitud_material .modal-body h2').html();
                            jQuery('#modal_solicitud_material .modal-body h2').hide();
                            jQuery('#modal_solicitud_material .modal-body br').hide();
                            jQuery('#modal_solicitud_material .modal-title').html(titulo);
                            jQuery('#modal_solicitud_material .modal-body .cancelar').hide();
                        }
                    });

                    jAlert(data.message, "Mensaje")
                } else {
                    jAlert(data.message, "Mensaje")
                }
            }).fail(function(response) {
                console.log(response)
            })

        }
    }

    $("#editar").click(function() {
        // jQuery("#modal_editar_detalle").modal('hide');

        // var id_detalle_material = $("#id_detalle_material").val();
        // var cantidad_despachada = parseFloat($("#cantidad_despachada").val());

        // console.log(id_detalle_material, cantidad_despachada)
        editar();
    });

});
</script>