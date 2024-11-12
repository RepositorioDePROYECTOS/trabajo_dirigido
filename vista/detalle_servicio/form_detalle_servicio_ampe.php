<?php


    
$id_solicitud_servicio = $_GET[id_solicitud_servicio_ampe];

// $registros_m =  $bd->Consulta("select * from servicio");
$registros_s = $bd->Consulta("SELECT * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio");
// echo "SELECT * from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio";
$registros_solicitud = $bd->Consulta("SELECT * from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio");
$registro_sol = $bd->getFila($registros_solicitud);

?>

<style>
    .d-none{
        display: none;
    }
</style>
<h2>Detalle de la solicitud</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <form name="frm_detalle_servicio" id="frm_detalle_servicio" method="post" role="form"
            class="validate_venta form-horizontal form-groups-bordered">
            <div class="form-group">

                <label for="fecha_registro" class="col-sm-2 control-label">Fecha de solicitud</label>
                <div class="col-sm-2">
                    <input type="text" name="fecha_registro" id="fecha_registro"
                        class="form-control required datepicker" placeholder=''
                        value='<?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));?>' readonly />
                </div>
                <label for="trabajador" class="col-sm-3 control-label">Nombre Solicitante</label>
                <div class="col-sm-3">
                    <input type="text" name="trabajador" id="trabajador" class="form-control required text"
                        placeholder='' value='<?php echo utf8_encode($registro_sol[nombre_solicitante]);?>' readonly />
                </div>
            </div>

            <div class="form-group bg-oferta">
                <div class="col-sm-10"><strong>AGREGAR SERVICIOS A SOLICITAR </strong> </div>
            </div>
            <input type="hidden" id="id_solicitud_servicio" name="$id_solicitud_servicio" value="<?php echo $id_solicitud_servicio;?>">
            <div class="form-group bg-oferta">
                <label for="servicio" class="col-sm-1 control-label">servicio</label>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-3 " id="key_descripcion">
                            <textarea name="descripcion_servicio" id="descripcion_servicio" class="form-control required text uppercase" placeholder="Escribir descripcion del servicio..."></textarea>
                        </div>
                        <div class="col-md-2 " >
                            <input type="text" name="unidad_medida" id="unidad_medida" class="form-control"
                                title="Introducir unidad de medida"  placeholder="Introducir Unidad medida..." />
                        </div> 
                        <div class="col-md-2 " id="key_precio">
                            <input type="text" name="precio_unitario" id="precio_unitario" class="form-control decimales"
                            title="Introducir precio unitario" placeholder="Introducir precio..." />
                        </div> 
                        <div class="col-md-2">
                            <input type="text" name="cantidad_solicitada" id="cantidad_solicitada"
                                class="form-control decimales" placeholder="Cantidad a solicitar" min="1" />
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
                <label for="detalle_servicioes" class="col-sm-2 control-label">Detalle de servicios</label>
                <div id="detalle_servicioes" class="col-sm-10 table-responsive">
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
                            <!-- realizar una consulta de acuerdo a la solicitud si tiene servicioes $solicitud->servicioes->count() e imprimir aqui -->
                            <?php
                        while($registro_s = $bd->getFila($registros_s)) 
                        {
                            $n++;
                            echo "<tr>";        
                            echo utf8_encode("
                                    <td>$n</td>
                                    <td>$registro_s[descripcion]</td>
                                    <td>$registro_s[unidad_medida]</td>
                                    <td>$registro_s[cantidad_solicitada]</td>
                                    <td>$registro_s[precio_unitario]</td>
                                    <td><a href='control/detalle_servicio_ampe/eliminar_detalle_servicio_ampe.php?id_detalle_servicio=$registro_s[id_detalle_servicio]' class='eliminar_lista btn btn-red btn-icon'>Quitar <i class='entypo-cancel'></i></a></td>"
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
        var id_solicitud_servicio = $("#id_solicitud_servicio").val();
        var descripcion_servicio = $("#descripcion_servicio").val() != '' ? $("#descripcion_servicio").val() : '';
        var unidad_medida = $("#unidad_medida").val() != '' ? $("#unidad_medida").val() : '';
        var precio_unitario = $("#precio_unitario").val() != '' ? $("#precio_unitario").val() : 0;
        var cantidad_solicitada = parseFloat($("#cantidad_solicitada").val());
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
                    url: "control/detalle_servicio_ampe/insertar_detalle_servicio_ampe.php",
                    data: {
                        'id_solicitud_servicio': id_solicitud_servicio,
                        'descripcion_servicio': descripcion_servicio,
                        'unidad_medida': unidad_medida,
                        'cantidad_solicitada': cantidad_solicitada,
                        'precio_unitario': precio_unitario,
                        'precio_total': cantidad_solicitada * precio_unitario
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

});
</script>